import java.util.Scanner;

public final class TicTacToe {
    private static final Scanner SCANNER = new Scanner(System.in);

    public static int X_WINNING_SCORE = -100;
    public static int O_WINNING_SCORE = 100;
    public static int TIE_SCORE = 0;

    public static void main(final String[] args) {
        var board = new char[9];

        System.out.println("You are Player 1!");
        print_board(board);

        boolean AI_turn = false;
        while (!game_finished(board)) {
            if (!AI_turn) {
                playerMove(board, 'X');
                print_board(board);
            } else {
                board[minimax(board, true, 0, Integer.MIN_VALUE, Integer.MAX_VALUE)[0]] = 'O';
                System.out.println("AI's move: ");
                print_board(board);
            }
            AI_turn = !AI_turn;
        }
    }

    private static boolean game_finished(char[] board) {
        return moves_left(board) == 0 || checkWin(board, 'X') || checkWin(board, 'O');
    }

    private static void playerMove(char[] board, char mark) {
        System.out.println(String.format("[player %s] Please pick a field from 1-9:", mark));
        int input = SCANNER.nextInt();
        while ((input < 1 || input > 9) || board[input - 1] != Character.MIN_VALUE) {
            System.out.println("Please input a number between 1 and 9 which is not taken");
            input = SCANNER.nextInt();
        }

        board[input - 1] = mark;
    }

    private static boolean checkWin(char[] board, char player) {
        if ((board[0] == player && player == board[3] && player == board[6]) ||
                (board[1] == player && player == board[4] && player == board[7]) ||
                (board[2] == player && player == board[5] && player == board[8]) ||

                (board[0] == player && player == board[1] && player == board[2]) ||
                (board[3] == player && player == board[4] && player == board[5]) ||
                (board[6] == player && player == board[7] && player == board[8]) ||

                (board[0] == player && player == board[4] && player == board[8]) ||
                (board[2] == player && player == board[4] && player == board[6])) {
            return true;
        }
        return false;
    }

    private static int moves_left(char[] board) {
        int remaining_moves = 0;
        for (char i : board) {
            if (i == Character.MIN_VALUE) {
                remaining_moves++;
            }
        }

        return remaining_moves;
    }

    private static int[] minimax(char[] board, boolean is_maximizer, int depth, int alpha, int beta) {
        int best_move = -1;

        if (checkWin(board, 'O')) {
            return new int[] { best_move, TicTacToe.O_WINNING_SCORE - depth };
        } else if (checkWin(board, 'X')) {
            return new int[] { best_move, TicTacToe.X_WINNING_SCORE + depth };
        }

        if (moves_left(board) == 0) {
            return new int[] { best_move, TicTacToe.TIE_SCORE + ( is_maximizer ? -1 * depth : depth ) };
        }

        if (depth == 10) {
            return new int[] { best_move, TicTacToe.TIE_SCORE + ( is_maximizer ? -1 * depth : depth ) };
        }

        if (is_maximizer) {
            for (int i = 0; i < 9; i++) {
                if (board[i] != Character.MIN_VALUE) {
                    continue;
                }

                board[i] = 'O';
                int score = minimax(board, false, depth + 1, alpha, beta)[1];
                if (score > alpha) {
                    best_move = i;
                    alpha = score;
                }
                board[i] = Character.MIN_VALUE;

                if (alpha >= beta) {
                    return new int[] { i, alpha - depth };
                }
            }

            return new int[] { best_move, alpha - depth };
        } else {
            for (int i = 0; i < 9; i++) {
                if (board[i] != Character.MIN_VALUE) {
                    continue;
                }

                board[i] = 'X';
                int score = minimax(board, true, depth + 1, alpha, beta)[1];

                if (score < beta) {
                    beta = score;
                    best_move = i;
                }

                board[i] = Character.MIN_VALUE;

                if (alpha >= beta) {
                    return new int[] { i, beta + depth };
                }
            }

            return new int[] { best_move, beta + depth };
        }
    }

    private static void print_board(char[] board) {
        StringBuilder string_builder = new StringBuilder();

        for (int i = 0; i < 9; i++) {
            if (i == 3 || i == 6) {
                string_builder.append('\n');
            }
            if (board[i] != Character.MIN_VALUE) {
                string_builder.append(String.format("%s ", board[i]));
            } else {
                string_builder.append("_ ");
            }
        }

        System.out.println(string_builder.toString());
    }
}