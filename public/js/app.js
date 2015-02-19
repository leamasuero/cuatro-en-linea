(function( $, Pusher, window, document, undefined ) {
    
    var Game = {
        
        init: function (config){
            Game.board = $(config.board);
            
            Game.board.on('click',config.addButton,this.addCoin);
            
            Game.endpoints = config.endpoints;
            Game.player = config.player;
            

            var pusher = new Pusher('6bb55fa9d449706bb5de');
            var channel = pusher.subscribe('game');
            channel.bind('newCoin', function(data) {
                console.log(data);
                console.log('td.row-'+data.row+'.column-'+data.column);
                console.log(Game.board.find('td.row-'+data.row+'.column-'+data.column ))
              Game.board.find('td.row-'+data.row+'.column-'+data.column ).text('leandro');
            });            
            
        },
        
        addCoin: function (e){
            var column = $(this).data('column');
            
            $.ajax({
                type: 'POST',
                url: Game.endpoints.addCoin,
                data: {player: Game.player, column: column},
                dataType: 'json'
            }).done(function(data){
                console.log(data)
            });            
        }        
        
    }
    
    Game.init({
        board: 'table',
        addButton: 'th button',
        endpoints: window.App.endpoints,
        player: window.App.player
    });
    
})( jQuery, Pusher, window, document);
