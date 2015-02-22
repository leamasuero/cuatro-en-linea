(function( $, Pusher, window, document, undefined ) {
    
    var Game = {
        
        init: function (config){
            Game.config = config;
            Game.board = $(config.board);
            
            Game.board.on('click',config.addButton,this.addCoin);
            
            Game.endpoints = config.endpoints;
            Game.player = config.player;
            
            var pusher = new Pusher('6bb55fa9d449706bb5de');
            var channel = pusher.subscribe('game');
            channel.bind('newCoin', this.insertCoin);            
            channel.bind('reset', this.reset);
            
            
        },
        
        insertCoin: function (data){
                console.log(data);
                Game.board.find('td.row-'+data.row+'.column-'+data.column ).html(Game.yieldCoin(data.player));            
        },
        
        yieldCoin: function(player){
          return $(Game.config.coin,{text: player,class:'coin'});
        },
        
        addCoin: function (e){
            var column = $(this).data('column');
            
            $.ajax({
                type: 'POST',
                url: Game.endpoints.addCoin,
                data: {player: Game.player, column: column},
                dataType: 'json'
            }).done(function(data){
                console.log(data);
                if(data.gameover == true){
                    alert(data.message);
                    Game.board.find(Game.config.addButton).off();
                }
            }).fail(function(data){
                alert(data.responseJSON.message);
            });            
        },
        
        reset: function (){
            console.log('Reset the game!');
            Game.board.find('tbody td').each(function(index,value){
                this.innerHTML = '';
            });
        }
        
    };
    
    Game.init({
        board: 'table',
        coin: '<div></div>',
        addButton: 'th button',
        endpoints: window.App.endpoints,
        player: window.App.player
    });
    
})( jQuery, Pusher, window, document);
