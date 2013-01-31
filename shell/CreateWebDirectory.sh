#!/bin/bash
echo -n "Enter full path of directory: "
read dir
if [ -d $dir ]
then
    echo "$dir already exists!"
else
    dirs=( "$dir" "$dir/bak" "$dir/docs" "$dir/images" "$dir/includes" "$dir/lib" "$dir/lib/css" "$dir/lib/js" "$dir/lib/xml" "$dir/swf" )
    numdirs=${#dirs[@]}
    for ((i=0;i<$numdirs;i++)); do
        destdir="${dirs[${i}]}"
        echo -n "creating $destdir... "
        mkdir $destdir
        if [ -d $destdir ]
        then
            chmod 775 $destdir
            chown webuser $destdir
            echo "done"
        else
            echo "error, mkdir failed"
        fi
    done
    echo -n "symbolically linking globals..."
    ln -s /web/global $dir/global
    echo "done"
    exit 0
fi
exit 0
