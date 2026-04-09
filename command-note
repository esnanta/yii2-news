# Refresh All New
cd /home/cassiopeia/Documents/github/html/yii2-news/console
php yii migrate/fresh --interactive=0
php yii rbac-migrate/up --interactive=0


cd /home/cassiopeia/Documents/github/html/yii2-news/console
php yii migrate refresh all --interactive=0

cd /home/cassiopeia/Documents/github/html/yii2-news/console
php yii rbac-migrate/down all --interactive=0
php yii rbac-migrate/up --interactive=0

php yii rbac-migrate/down --interactive=0
php yii rbac-migrate/up --interactive=0

php console/yii migrate/down
php console/yii migrate/up

sudo chown -R $USER:www-data /home/cassiopeia/Documents/github/html/yii2-news
find /home/cassiopeia/Documents/github/html/yii2-news -type d -exec chmod 775 {} \;
find /home/cassiopeia/Documents/github/html/yii2-news -type f -exec chmod 664 {} \;
sudo chown -R www-data:www-data /home/cassiopeia/Documents/github/html/yii2-news/frontend/runtime
sudo chown -R www-data:www-data /home/cassiopeia/Documents/github/html/yii2-news/frontend/web/assets
sudo find /home/cassiopeia/Documents/github/html/yii2-news/frontend/runtime -type d -exec chmod 775 {} \;
sudo find /home/cassiopeia/Documents/github/html/yii2-news/frontend/runtime -type f -exec chmod 664 {} \;
sudo find /home/cassiopeia/Documents/github/html/yii2-news/frontend/web/assets -type d -exec chmod 775 {} \;
sudo find /home/cassiopeia/Documents/github/html/yii2-news/frontend/web/assets -type f -exec chmod 664 {} \;

sudo chown -R www-data:www-data /home/cassiopeia/Documents/github/html/yii2-news/backend/runtime
sudo chown -R www-data:www-data /home/cassiopeia/Documents/github/html/yii2-news/backend/web/assets
sudo find /home/cassiopeia/Documents/github/html/yii2-news/backend/runtime -type d -exec chmod 775 {} \;
sudo find /home/cassiopeia/Documents/github/html/yii2-news/backend/runtime -type f -exec chmod 664 {} \;
sudo find /home/cassiopeia/Documents/github/html/yii2-news/backend/web/assets -type d -exec chmod 775 {} \;
sudo find /home/cassiopeia/Documents/github/html/yii2-news/backend/web/assets -type f -exec chmod 664 {} \;

chmod -R 777 /home/cassiopeia/Documents/github/html/yii2-news/common/models/