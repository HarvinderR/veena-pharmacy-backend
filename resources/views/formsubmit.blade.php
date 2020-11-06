<div class="container">
    <form action="saveData" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Enter username">
        <br>
        <input type="password" name="password" placeholder="Enter password"><br>
        <button type="submit">Login</button>
    </form>
</div>
