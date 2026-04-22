<style>
    .order-wrapper {
        display: flex; justify-content: center; align-items: center;
        height: 80vh; margin: 0;
    }
    .container {
        width: 650px; height: 550px; background-color: #ffffff;
        border: 2px solid #4F90FF; border-radius: 40px;
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; box-sizing: border-box; padding: 40px;
    }
    h2 { font-size: 32px; font-weight: normal; margin-bottom: 40px; margin-top: 0; color: #000; }
    .input-field {
        width: 420px; height: 50px; background-color: #ebebeb;
        border: 2px solid #4F90FF; border-radius: 12px;
        margin-bottom: 25px; padding: 0 20px; font-size: 24px;
        color: #000; outline: none; box-sizing: border-box;
    }
    .price-label { width: 420px; font-size: 24px; color: #000; margin-bottom: 40px; text-align: left; }
    .btn-order {
        width: 250px; height: 70px; background-color: #4F90FF;
        border: none; border-radius: 12px; color: white;
        font-size: 24px; cursor: pointer;
    }
</style>
<div class="order-wrapper">
    <form class="container" method="POST">
        <h2>Заказать товар</h2>

        <select name="product_id" id="product-select" class="input-field" required>
            <option value="" disabled selected>Выберите товар</option>
            <?php foreach ($products as $product): ?>
                <option value="<?= $product->id ?>" data-price="<?= $product->price ?>">
                    <?= $product->name ?> (<?= $product->price ?> ₽/ед.)
                </option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="quantity" id="quantity-input" class="input-field" placeholder="Количество" required min="1">

        <select name="supplier" class="input-field" required>
            <option value="" disabled selected>Поставщик</option>
            <?php foreach ($suppliers as $s): ?>
                <option value="<?= $s->name ?>"><?= $s->name ?></option>
            <?php endforeach; ?>
        </select>

        <div class="price-label">Итоговая цена: <span id="total-price">0.00</span> ₽</div>

        <button type="submit" class="btn-order">Заказать</button>
    </form>
</div>

<script>
    const productSelect = document.getElementById('product-select');
    const qtyInput = document.getElementById('quantity-input');
    const totalDisplay = document.getElementById('total-price');

    function calculateTotal() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const price = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) : 0;
        const qty = parseFloat(qtyInput.value) || 0;
        
        const total = price * qty;
        totalDisplay.textContent = total.toLocaleString('ru-RU', { minimumFractionDigits: 2 });
    }

    productSelect.addEventListener('change', calculateTotal);
    qtyInput.addEventListener('input', calculateTotal);
</script>