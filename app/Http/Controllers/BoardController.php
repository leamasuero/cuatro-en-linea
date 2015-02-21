<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as IlluminateResponse;

class BoardController extends Controller {

    private $gameBoard;
    private $board;

    public function __construct() {
        $this->gameBoard = new \Acme\GameBoard();
        $this->board = $this->gameBoard->getBoard();
        $this->pusher = \App::make('Pusher');
        
        $this->middleware('guest');        
    }
    
    public function home(){
        $title = 'Connect four';
        return view('home',compact('title'));
    }

    public function play($player) {
        $title = "Player {$player}";

        $board = $this->board;

        return view('board', compact('title', 'player', 'board'));
    }

    public function addCoin(Request $request) {
        
        $player = $request->input('player');
        $column = $request->input('column');
        
        if ($this->gameBoard->isGameOver()) {
            return \Response::json(
                    ['message' => "Game over. Please restart the game."]
                    , IlluminateResponse::HTTP_BAD_REQUEST);
        }
        
        if (!$this->gameBoard->isCurrentPlayer($player)) {
            return \Response::json(
                    ['message' => "Wait for your turn."]
                    , IlluminateResponse::HTTP_BAD_REQUEST);
        }

        if ($this->gameBoard->isColumFull($column)) {
            return \Response::json(
                    ['message' => "That column is full. Try another one."]
                    , IlluminateResponse::HTTP_BAD_REQUEST);            
        }

        $jugada = $this->gameBoard->addCoin($column);
        
        
        $this->pusher->trigger('game', 'newCoin', $jugada);
        
        if($this->gameBoard->didPlayerWin($jugada['player'])){
            
            return \Response::json(
                            [
                            'message' => "Player {$jugada['player']} won. Game over.",
                            'jugada' => $jugada,
                            'gameover' => true,
                            ]
                            , IlluminateResponse::HTTP_ACCEPTED);
                            
        }
        
        return \Response::json(
                        [
                        'message' => "Coin successfully added. Wait for you turn.",
                        'jugada' => $jugada,
                        'gameover' => false
                        ]
                        , IlluminateResponse::HTTP_ACCEPTED);          
    }
    
    public function reset(){
        $this->gameBoard->reset();
    }

}
