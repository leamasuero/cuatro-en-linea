<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BoardController extends Controller {

    private $gameBoard;
    private $board;

    public function __construct() {
        $this->gameBoard = new \Acme\GameBoard();
        $this->board = $this->gameBoard->getBoard();
        $this->pusher = \App::make('Pusher');
//        dd($this->pusher);
    }

    public function play($player) {
        $title = "Welcome player {$player}";

        $board = $this->board;

        return view('board', compact('title', 'player', 'board'));
    }

    public function addCoin(Request $request) {
        
        $player = $request->input('player');
        $column = $request->input('column');
        
        if(! $this->gameBoard->isCurrentPlayer($player)){
           die(json_encode(
                [
                    'ok' => false,
                    'message' => "Wait for your turn."
                ]
            ));            
        }

        if ($this->gameBoard->isColumFull($column)) {
            die(json_encode(
                [
                    'ok' => false,
                    'message' => "Column {$column} is full. Put your coin in another one."
                ]
            ));
        }

        $rowUsed = $this->gameBoard->addCoin($column);
        
        
        $this->pusher->trigger('game', 'newCoin', ['row' => $rowUsed, 'column' => $column]);

        die(json_encode(
            [
                'ok' => true,
                'row' => $rowUsed,
                'message' => "Coin successfully added. Wait for you turn."
            ]
        ));
    }

}
