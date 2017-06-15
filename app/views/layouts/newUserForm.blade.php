<center>
    <div class="col-xs-12">
        <label>
            <span>نام</span>
            <input type="text" name="name" value="{{$name}}" maxlength="40" required autofocus>
        </label>
    </div>
    <div class="col-xs-12">
        <label>
            <span>نام خانوادگی</span>
            <input type="text" name="family" value="{{$family}}" required maxlength="40">
        </label>
    </div>
    <div class="col-xs-12">
        <label>
            <span>نام کاربری</span>
            <input type="text" name="userName" value="{{$userName}}" required maxlength="40">
        </label>
    </div>
    <div class="col-xs-12">
        <label>
            <span>پسورد</span>
            <input type="password" name="pas" maxlength="8" required value="{{$pas}}">
        </label>
    </div>
    <div class="col-xs-12">
        <label>
            <span>شماره ی تلفن همراه</span>
            <input type="text" value="{{$phoneNum}}" name="phoneNum" required maxlength="11">
        </label>
    </div>
</center>