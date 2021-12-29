import moment from "moment";

$(".sortable").sortable({
    update: function(event, ui) {
        const datas = $(event.target).sortable("toArray", {
            attribute: "data-index"
        });

        const dateCurrent = moment();
        let seconds = 0;
        datas.forEach(function(id) {
            const url = "/admin/highlights/" + id;
   
            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                data: {
                    _method: "PUT",
                    updated_at: dateCurrent.subtract(seconds, 'seconds').format("YYYY-MM-DD hh:mm:ss")
                },
                success: function(response) {
                    //console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
  
            seconds = seconds + 1;
        });
    }
});
