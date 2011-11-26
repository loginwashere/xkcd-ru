(function( $ ) {
    var fields = {
        comicsContainer: false,
        paginationContainer: false,
        setComicsContainer: function(object) {
            this.comicsContainer = object;
        },
        setPaginationContainer: function(object) {
            this.paginationContainer = object;
        },
        paginate: function(event) {
            var pagination = event.data.options
            event.preventDefault();
            $.ajax({
                method: 'post',
                url: $(this).attr('href'),
                data: {'format': 'json'},
                success: function(data){
                    pagination.paginationContainer.each(function(){
                        pagination.paginationContainer.html(data.pagination);
                    });
                    pagination.comicsContainer.find('h2').html(data.comics.xkcd_title);
                    pagination.comicsContainer.find('img').attr({
                        'src': '/images/' + data.comics.xkcd_filename,
                        'title': data.comics.xkcd_description,
                        'alt': data.comics.xkcd_description                        
                    });
                    pagination.comicsContainer.find('.transcript').html(data.comics.xkcd_transcription);
                }
            });
        }
    }
    
    $.fn.pagination = function(comicsContainer, paginationContainer) {
        fields.setComicsContainer(comicsContainer);
        fields.setPaginationContainer(paginationContainer);
        fields.paginationContainer.delegate('a', 'click', {options: fields}, fields.paginate);

    };
})( jQuery );

$(document).ready(function(){
    $().pagination($('#comics'), $('.pagination'));
});






















