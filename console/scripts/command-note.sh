#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
cd "$ROOT_DIR"

run() {
  echo ""
  echo "=================================================="
  echo "+ $*"
  echo "=================================================="
  echo ""

  "$@"
}

show_help() {
  cat <<'EOF'
Usage:
  ./console/scripts/command-note.sh <action>

Database:
  db-create
  db-create-main
  db-create-test

  db-drop
  db-drop-main
  db-drop-test
  db-drop-force

Migration:
  db-migrate
  db-migrate-main
  db-migrate-test
  db-migrate-down
  db-migrate-down-main
  db-migrate-down-test

Other:
  fix-permissions
  help
EOF
}

run_action() {
  local action="${1:-help}"

  case "$action" in

    db-create)
      run php console/yii db/create
      ;;

    db-create-main)
      run php console/yii db/create main
      ;;

    db-create-test)
      run php console/yii db/create test
      ;;

    db-drop)
      run php console/yii db/drop
      ;;

    db-drop-main)
      run php console/yii db/drop main
      ;;

    db-drop-test)
      run php console/yii db/drop test
      ;;

    db-drop-force)
      run php console/yii db/drop all 1
      ;;

    db-migrate)
      run php console/yii db/migrate
      ;;

    db-migrate-main)
      run php console/yii db/migrate main
      ;;

    db-migrate-test)
      run php console/yii db/migrate test
      ;;
    db-migrate-down)
      run php console/yii db/migrate-down
      ;;
    db-migrate-down-main)
      run php console/yii db/migrate-down main
      ;;
    db-migrate-down-test)
      run php console/yii db/migrate-down test
      ;;

    fix-permissions)
      run sudo chown -R www-data:www-data frontend/web/assets
      run sudo chown -R www-data:www-data frontend/runtime
      run sudo chown -R www-data:www-data backend/web/assets
      run sudo chown -R www-data:www-data backend/runtime
      ;;

    help|-h|--help)
      show_help
      ;;

    *)
      echo "Unknown action: $action" >&2
      show_help
      exit 1
      ;;
  esac
}

if [[ $# -eq 0 ]]; then
  show_help
else
  run_action "$1"
fi