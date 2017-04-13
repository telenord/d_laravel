#!/bin/bash
set -e

#Simple git based deployment
# - it should be run on server
# - the server source should be configured to have access to git (as well correct branch) and tools
# - it's very optimistic for errors and will break/stop if something wrong (and leave site in maintenance mode), then you have to fix manually

#get paths (if run not from correct directory)
SOURCE="${BASH_SOURCE[0]}"

#use code below to resolve symlinks
#while [ -h "$SOURCE" ]; do # resolve $SOURCE until the file is no longer a symlink
#  DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"
#  SOURCE="$(readlink "$SOURCE")"
#  [[ $SOURCE != /* ]] && SOURCE="$DIR/$SOURCE" # if $SOURCE was a relative symlink, we need to resolve it relative to the path where the symlink file was located
#done
#export ROOT_DIR="$( cd -P "$( dirname "$SOURCE" )" && pwd )"

export ROOT_DIR="$( cd -L "$( dirname "$SOURCE" )" && pwd )"

cd "$ROOT_DIR"
    
echo "Deploy production"

#check if git works
git ls-remote &> /dev/null

php artisan down
git pull
make install-dependencies-production
php artisan migrate --force --no-interaction --verbose
make production-optimize
php artisan up

echo "Production has been updated successfuly"
