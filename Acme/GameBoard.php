<?php

namespace Acme;

class GameBoard {

    private $board;
    private $gameboardRepresentation;
    private $currentPlayer;

    public function __construct() {
        $this->gameboardRepresentation = storage_path() . '/boardgame';


        if (file_exists($this->gameboardRepresentation)) {
            $gameState = unserialize(file_get_contents($this->gameboardRepresentation));

            $this->board = $gameState['board'];
            $this->currentPlayer = $gameState['turn'];
//            dd($this->currentPlayer);
        } else {

            $this->currentPlayer = '1';

            $this->board = new \SplFixedArray(6);

            for ($i = 0; $i < count($this->board); $i++) {
                $this->board[$i] = new \SplFixedArray(7);
            }
        }
    }

    public function isColumFull($column) {
        return !empty($this->board[0][$column]);
    }

    public function addCoin($column) {
        for ($row = count($this->board) - 1; $row >= 0; $row--) {
            if (empty($this->board[$row][$column])) {
                $this->board[$row][$column] = $this->currentPlayer;
                
                $this->switchPlayer();
                
                return $row;
            }
        }
    }

    public function isCurrentPlayer($player){
        return $this->currentPlayer == $player;
    }
    
    public function getBoard() {
        return $this->board;
    }

    public function switchPlayer() {
        if ($this->currentPlayer == '1') {
            $this->currentPlayer = '2';
        } else {
            $this->currentPlayer = '1';
        }

    }

    public function __destruct() {
        $gameState = ['board' => $this->board, 'turn' => $this->currentPlayer];
        file_put_contents($this->gameboardRepresentation, serialize($gameState));
    }

}
