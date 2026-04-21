<style>
    .add-form-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 70vh;
        margin: 0;
    }

    .container-form {
        width: 600px;
        height: 400px;
        background-color: #ffffff;
        border: 2px solid #4F90FF;
        border-radius: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    h2 {
        font-size: 32px;
        font-weight: normal;
        margin-bottom: 40px;
        margin-top: 0;
    }

    .input-field {
        width: 380px;
        height: 45px;
        background-color: #ebebeb;
        border: 2px solid #4F90FF;
        border-radius: 10px;
        margin-bottom: 45px;
        padding: 0 15px;
        font-size: 22px;
        color: #000;
        outline: none;
    }

    .btn-add {
        width: 220px;
        height: 70px;
        background-color: #4F90FF;
        border: none;
        border-radius: 10px;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }
</style>

<div class="add-form-wrapper">
    <form class="container-form" method="POST">
        <h2>Новое подразделение</h2>
        <input type="text" name="name" class="input-field" placeholder="Название" required>
        <button type="submit" class="btn-add">Добавить</button>
    </form>
</div>