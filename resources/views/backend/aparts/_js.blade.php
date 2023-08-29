<script>
$(document).ready(function() {

    // Изменение статуса новости
    $('.news_status').change(function (){
        // $('#DeviceParamSetFormStatus').html(loader);
        let newsId = $(this).attr('data-news-id');
        let statusId = $(this).find(":selected").val();
        let url = '{{ route('backend.news.list.setNewsStatus', '%%')  }}';

        $.post(url.replace('%%', newsId),
            {
                "_method": "PATCH",
                "status": statusId
            },
            function(data){
                if (data.status !== 0) {
                    $('#DeviceParamSetFormStatus').addClass('msg_warning').text( data.response );
                    return false;
                }
                $('#DeviceParamSetFormStatus').addClass('msg_success').text( data.response ); //.delay(3000).fadeOut(1000).show();
                // location.reload();
            }
        );
        return false;
    });
});
</script>
