#!/usr/bin/env bash
set -euo pipefail

PATH="$HOME/bin:/usr/local/bin:/usr/bin:/bin:$PATH"

BUCKET="idf-whisper-box-backups"
SQLITE_VOLUME="${SQLITE_VOLUME:-idf-whisper-box_sqlite-data}"
BOOK_LOAN_VOLUME="${BOOK_LOAN_VOLUME:-idf-whisper-box_book-loan-photos}"
STAMP="$(date +%Y%m%d-%H%M%S)"
TMP="/tmp/idf-backup-${STAMP}.tar.gz"
RETENTION_DAYS=28
LOG="$HOME/idf-backup.log"

{
  echo "=== backup run ${STAMP} ==="

  docker run --rm --user "$(id -u):$(id -g)" -v "${SQLITE_VOLUME}:/src/database" \
    -v "${BOOK_LOAN_VOLUME}:/src/book-loans" \
    -v /tmp:/dest alpine \
    tar -czf "/dest/idf-backup-${STAMP}.tar.gz" -C /src database book-loans

  oci os object put --bucket-name "$BUCKET" --file "$TMP" --name "idf-backup-${STAMP}.tar.gz" --force
  rm -f "$TMP"

  CUTOFF="$(date -d "-${RETENTION_DAYS} days" +%Y%m%d)"
  # Date comparison relies on YYYYMMDD format: both 8 digits, starting with non-zero
  (oci os object list --bucket-name "$BUCKET" --query "data[].name" --raw-output \
    | grep -oE 'idf-backup-[0-9]{8}-[0-9]{6}\.tar\.gz' || true) \
    | while read -r name; do
        [ -z "$name" ] && continue
        OBJ_DATE="${name#idf-backup-}"
        OBJ_DATE="${OBJ_DATE:0:8}"
        if [ "$OBJ_DATE" -lt "$CUTOFF" ]; then
          oci os object delete --bucket-name "$BUCKET" --name "$name" --force || echo "WARN: failed to delete $name"
        fi
      done

  echo "=== backup run ${STAMP} done ==="
} >> "$LOG" 2>&1
