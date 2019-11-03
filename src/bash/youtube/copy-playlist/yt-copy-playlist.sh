#!/bin/bash
URL="${1}"
NAME="${2}"
BASEDIR="$( cd "$(dirname "$0")" ; pwd -P )"
CURRENTDIR="$( cd "$(dirname ".")" ; pwd -P )"

mkdir "${NAME}"
cd "${NAME}"
youtube-dl -f 'bestvideo[ext=mp4]+bestaudio[ext=m4a]/bestvideo+bestaudio' --merge-output-format mp4 -o "%(playlist_index)s.%(ext)s" "$URL"

mkdir output
rm list.txt
for i in $(ls *.mp4) ; do echo "file '$i'" >> list.txt ; done
ffmpeg -f concat -safe 0 -i list.txt -c copy "output/output.mp4"

VIDEOPATH="${CURRENTDIR}/${NAME}/output/output.mp4"

cd "${BASEDIR}/youtube-upload/bin"

./youtube-upload --title="${NAME}" --privacy="private" --client-secrets="${BASEDIR}/youtube-upload/client_secret_747124235720-8khqm17o2l8rg7vink2tajedpdfrtc7h.apps.googleusercontent.com.json" --credentials-file="${BASEDIR}/youtube-upload/credentials.json" "$VIDEOPATH"