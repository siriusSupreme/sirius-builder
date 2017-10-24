# Carousel

`Sirius\Builder\Widgets\Carousel`Used to generate carousel components:

```php
use Sirius\Builder\Widgets\Carousel;

$items = [
    [
        'image' => 'http://xxxx/xxx.jpg',
        'caption' => 'xxxx',
    ],
    [
        'image' => 'http://xxxx/xxx.jpg',
        'caption' => 'xxxx',
    ],
    [
        'image' => 'http://xxxx/xxx.jpg',
        'caption' => 'xxxx',
    ],
];

$carousel = new Carousel($items);

echo $carousel->render();
```

The `Carousel::__construct($items)`, `$items` parameter sets the content element of the sliding album.


