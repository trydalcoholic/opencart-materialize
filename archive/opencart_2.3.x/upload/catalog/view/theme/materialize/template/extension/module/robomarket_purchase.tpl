    <?php if(!$email): ?>
    <button onclick="javascript: location.href = '/index.php?route=account/login';">Да, войти на сайт</button>

    <a id="popup-checkout-button" onclick="javascript:get_robomarket_login(0);" href="http://market.robokassa.ru/cart/insert?offerId=<?=$sku?>">Нет, перейти в Робо.Маркет</a>
  <?php else: ?>
    <a id="popup-checkout-button" onclick="javascript:get_robomarket_login(1,'<?=$email?>');" style="width: 100%;" href="http://market.robokassa.ru/cart/insert?offerId=<?=$sku?>">Перейти в Робо.Маркет</a>
  <?php endif; ?>