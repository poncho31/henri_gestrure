export default class Record{

    run(){

            $('.runRecord').on('click', function(){
                let id = $(this).attr('data-id')
                let url = $(this).attr('data-url')
                console.log("RUN" , id);

                let runRecord = action(url,{canRecord:true}, id)

                $('#runRecord'+id).toggleClass('is-success').addClass('is-info').toggleClass('display')
                $('#stopRecord'+id).toggleClass('display').toggleClass('is-light');
            })

            $('.stopRecord').on('click', function(){
                let id = $(this).attr('data-id')
                let url = $(this).attr('data-url')
                console.log("RUN" , id);

                let runRecord = action(url,{record:true}, id)
                $('#stopRecord'+id).toggleClass('display').toggleClass('is-light');
                $('#runRecord'+id).toggleClass('is-success').addClass('is-info').toggleClass('display')
            })


        function action(url,data, id){
            let output=''
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                method: "POST",
                url: url,
                data: data,
                success: function(e) {
                    console.log('SUCCESS',e)
                    console.log("ID : "+ '#output'+id)
                    if(e.error){
                        $('#output'+id).html(e.error)
                    }
                    else{
                        $('#output'+id).html(e)
                    }
                    console.log('OUTPUT TEST :',$('#output'+id))
                    // $('#output').html(e)
                },
                error: function(er){
                    $('#output'+id).html("<pre>"+'ERREUR : '+er.responseText +' ' + er.responseText+"</pre>")
                    console.log('ERROR',er)
                }
            })

            return output;
        }
    }


}
