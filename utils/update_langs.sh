#!/bin/bash

# example:
# bash update.sh 1 "${PWD}/client" "php,js,tpl" "translate" "php_array" "${PWD}/client/langs" "http://langs" ""

ID_PROJECT=$1
SEARCH_FOLDER=$2 # folder where search the usage of translations
EXTS=$3 # extensions where search (js, php, etc)
FUNC_NAMES=$4 # translation func name (for example: translate)
OUTPUT_METHOD=$5 # output format: json, json_var, php_array, i18n... https://github.com/JoniJnm/langs/blob/develop/controllers/ExportController.php
OUTPUT_FOLDER=$6 # where to save files
URL=$7 # URL of langs api
Authorization=$8 # HTTP Authorization header (can be empty)
PWD=`pwd`

if [ $# -ne 8 ]; then
	echo "Invalid args (${#})" 
	exit 0 
fi

php "${PWD}/search_langs.php" "${SEARCH_FOLDER}" "${EXTS}" "${FUNC_NAMES}" "${PWD}/dic.json"

curl "${URL}/rest/import/hashes?id_project=${ID_PROJECT}" \
	-X POST -H "Content-Type: multipart/form-data" \
	-H "Authorization: ${Authorization}" \
	-F "dic=@${PWD}/dic.json"
echo

curl -o langs.zip "${URL}/rest/export/${OUTPUT_METHOD}?id_project=${ID_PROJECT}" -H "Authorization: ${Authorization}"
unzip -o langs.zip -d "${OUTPUT_FOLDER}"

rm "${PWD}/dic.json"
rm langs.zip