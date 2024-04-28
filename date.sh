# https://qiita.com/azusanakano/items/b39bd22504313884a7c3
cp /etc/sysconfig/clock /etc/sysconfig/clock.org
echo -e 'ZONE="Asia/Tokyo"\nUTC=false' > /etc/sysconfig/clock
cp /etc/localtime /etc/localtime.org
ln -sf  /usr/share/zoneinfo/Asia/Tokyo /etc/localtime