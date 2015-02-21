<?php

namespace Acme;

class GameBoard {

    private $board;
    private $gameboardRepresentation;
    private $currentPlayer;
    private $gameOver;
    private $disk;

    public function __construct() {
        $this->gameboardRepresentation = 'boardgame';
        
        $this->disk = \Storage::disk('local');

        if ($this->disk->exists($this->gameboardRepresentation)) {
            $gameState = unserialize($this->disk->get($this->gameboardRepresentation));

            $this->board = $gameState['board'];
            $this->currentPlayer = $gameState['turn'];
            $this->gameOver = $gameState['gameOver'];
            
        } else {

            $this->currentPlayer = '1';
            $this->gameOver = false;

            $this->board = new \SplFixedArray(6);

            for ($i = 0; $i < count($this->board); $i++) {
                $this->board[$i] = new \SplFixedArray(7);
            }
        }
    }
    
    public function isGameOver(){
        return $this->gameOver;
    }
    
    public function reset(){
        $this->disk->delete($this->gameboardRepresentation);
    }

    public function isColumFull($column) {
        return !empty($this->board[0][$column]);
    }

    public function addCoin($column) {
        for ($row = count($this->board) - 1; $row >= 0; $row--) {
            if (empty($this->board[$row][$column])) {
                $this->board[$row][$column] = $this->currentPlayer;
                
                $jugada = [
                    'row' => $row,
                    'column' => $column,
                    'player' => $this->currentPlayer
                ];
                
                $this->switchPlayer();
                
                return $jugada;
            }
        }
    }
    
    public function didPlayerWin($player){
        foreach($this->board as $rowIndex => $row){
            foreach($row as $columnIndex => $column){
                
                try {
                    
                    if ($this->testHorizontal($rowIndex, $columnIndex, $player)) {
                        $this->gameOver = true;
                        return true;
                     }

                     if ($this->testVertical($rowIndex, $columnIndex, $player)) {
                         $this->gameOver = true;
                         return true;
                     }              
                     
                } catch (\RuntimeException $ex) {
                    // out of range. 
                }
                
 
            }
        }
        
        return false;
    }
    
    public function testHorizontal($rowIndex, $columnIndex, $player) {
        return
                $this->board[$rowIndex][$columnIndex] == $player     &&
                $this->board[$rowIndex][$columnIndex + 1] == $player &&
                $this->board[$rowIndex][$columnIndex + 2] == $player &&
                $this->board[$rowIndex][$columnIndex + 3] == $player
        ;
    }
    
    public function testVertical($rowIndex, $columnIndex, $player) {
        return
                $this->board[$rowIndex][$columnIndex] == $player     &&
                $this->board[$rowIndex + 1][$columnIndex] == $player &&
                $this->board[$rowIndex + 2][$columnIndex] == $player &&
                $this->board[$rowIndex + 3][$columnIndex] == $player
        ;
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
        $gameState = ['board' => $this->board, 'turn' => $this->currentPlayer, 'gameOver' => $this->gameOver];
        $this->disk->put($this->gameboardRepresentation, serialize($gameState));
    }

}
