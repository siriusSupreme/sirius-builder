# Infobox组件

`Sirius\Builder\Widgets\InfoBox`类用来生成信息展示块：

```php
use Sirius\Builder\Widgets\InfoBox;

$infoBox = new InfoBox('New Users', 'users', 'aqua', '/admin/users', '1024');

echo $infoBox->render();

```

效果请参考后台首页的布局文件[HomeController.php](/src/Commands/stubs/ExampleController.stub)的`index()`方法中，关于`InfoBox`的部分。
