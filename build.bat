php make.php
php -w dist/core/appCore.php > dist/core/newAppCore.php
cd dist/core/
del appCore.php
copy newAppCore.php appCore.php
del newAppCore.php