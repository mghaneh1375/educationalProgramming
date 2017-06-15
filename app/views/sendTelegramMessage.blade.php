
<form method="post" action="https://api.telegram.org/bot298697135:AAG1sTtuaXGvxand-KMonqUl8rkzt_He0rw/sendDocument?" enctype="multipart/form-data">
    <input type="text" name="chat_id" value="88737881">
    <input type="text" name="document" value="">
    {{--<input type="file" name="document" value="<?=storage_path("mpdf_3.pdf")?>">--}}
    <input type="submit" value="send">
</form>

<script>
    document.getElementsByName("form")[0].submit();
</script>