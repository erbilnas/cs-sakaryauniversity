/**************************************************************************************************************************************
** SAKARYA ÜNİVERSİTESİ                                                                            
** BİLGİSAYAR VE BİLİŞİM BİLİMLERİ FAKÜLTESİ                                
** BİLGİSAYAR MÜHENDİSLİĞİ BÖLÜMÜ                                                                  
** NESNEYE DAYALI PROGRAMLAMA DERSİ                                              
** 2015-2016 BAHAR DÖNEMİ                                                                        
**                                                                                            
**  ÖDEV NUMARASI..........: PROJE/TASARIM                                                                                          
**  ÖĞRENCİ ADI............: ERBİL NAS                                                                              
**  ÖĞRENCİ NUMARASI.......: B151210053                                                                                                  
**  DERSİN ALINDIĞI GRUP...: E GRUBU 
**
**  ÖDEVİN KONUSU..........: ARKANOİD KLONU BİR OYUN GELİŞTİRME                                                                                            
**************************************************************************************************************************************/

using System;
using System.Collections.Generic;
using System.Drawing;
using System.Windows.Forms;

namespace BaseGame
{
    static class Program
    {
        // General
        public static Form GameWindow;
        private static Timer movementTimer;
        private static Timer scoreTimer;

        // User Interface elements
        private static PictureBox leftSideBar;
        private static PictureBox rightSideBar;
        private static int leftMargin;
        private static int rightMargin;
        private static Label scoreLabel;
        private static Label livesLabel;
        private static Label instructionsLabel;

        // Levels
        private static List<char[,]> levels;
        private static int currentLevel = 0;

        // Player
        private static Player player;

        // Ball
        private static Ball ball;

        // Blocks (targets)
        private static List<Block> blocks;

        // Stats
        private static int lives;
        private static int score;

        // Endgame and highscores
        private static Label restartGameLabel;
        private static Label submitScoreLabel;
        private static Label findScoreLabel;
        private static TextBox submitScoreTextBox;
        private static TextBox findScoreTextBox;
        private static DataGridView highscoresTable;
        private static Score[] scores;

        private struct Score
        {
            public int score;
            public string name;
            public Score(int score, string name)
            {
                this.score = score;
                this.name = name;
            }
        }

        private static void Main()
        {
            // Create the main game window and set its properties
            GameWindow = new Form();
            GameWindow.Size = new Size(1366, 720);
            GameWindow.MinimumSize = GameWindow.Size;
            GameWindow.MaximumSize = GameWindow.Size;
            GameWindow.MaximizeBox = false;
            GameWindow.StartPosition = FormStartPosition.CenterScreen;
            GameWindow.BackColor = Color.FromArgb(10, 10, 10);
            GameWindow.ForeColor = Color.White;

            // Create the user interface elements
            createUserInterface();

            // Define the level layouts
            createLevelLayouts();
            
            // Initialize the timers
            movementTimer = new Timer();
            movementTimer.Interval = 20;
            movementTimer.Tick += movementTimer_Tick;
            scoreTimer = new Timer();
            scoreTimer.Interval = 1000;

            generateHighscores();

            // Start the game
            startGame();

            Application.Run(GameWindow);
        }

        // KEYDOWN EVENT
        private static void event_keyDown(object sender, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.Space)
            {
                ball.launched = true;
            }
            if (e.KeyCode == Keys.Left) player.isMovingLeft = true;
            if (e.KeyCode == Keys.Right) player.isMovingRight = true;
        }
        
        // KEYUP EVENT
        private static void event_keyUp(object sender, KeyEventArgs e)
        {
            if (e.KeyCode == Keys.Left) player.isMovingLeft = false;
            if (e.KeyCode == Keys.Right) player.isMovingRight = false;
        }
        
        // Mobement timer tick event
        private static void movementTimer_Tick(Object myObject, EventArgs myEventArgs)
        {
            // Move the player if an arrow key is currently pressed (provided he is within the playable zone)
            if (player.isMovingLeft && player.Location.X > leftMargin)
                player.moveLeft();
            if (player.isMovingRight && player.Location.X + player.Size.Width < rightMargin)
                player.moveRight();

            // Move the ball
            if (ball.launched)
            {
                ball.move();
            }
            /* If the ball hasn't still been launched, move it along with the player */
            else
            {
                ball.Location = new Point(
                    player.Location.X + player.Size.Width / 2 - ball.Size.Width / 2,
                    player.Location.Y - ball.Size.Height);
            }

            // Process collision with active blocks
            for (int i = 0; i < blocks.Count; i++)
            {
                bool blockDestroyed = false;

                // Check if block was destroyed by ball
                if (ball.collision(blocks[i])) blockDestroyed = true;
                        
                if (blockDestroyed) {
                    GameWindow.Controls.Remove(blocks[i]);
                    blocks.RemoveAt(i);
                    score += 10;
                    if (blocks.Count == 0)
                    {
                        // All blocks destroyed => Win game and show highscores
                        endGame();
                    }
                }
            }

            /* Process collision with player */
            ball.collision(player);

            // Collision with left or right margins of the Game Window => Flip ball direction horizontally
            if (ball.Location.X <= leftMargin || ball.Location.X + ball.Size.Width >= rightMargin)
                ball.flipX();

            // Collision with top margin => Flip ball direction vertically
            if (ball.Location.Y <= 0)
                ball.flipY();

            // Collision with bottom margin => Lose life
            if (ball.Location.Y >= GameWindow.ClientRectangle.Height)
            {
                GameWindow.Controls.Remove(ball);
                lives--;
                if (lives > 0)
                {
                    createNewBall();
                }
                else
                {
                    // Player lost all lives => Lose game and show highscores
                    endGame();
                }
            }

            // Update user interface elements
            scoreLabel.Text = "SCORE\n" + score;
            livesLabel.Text = "LIVES\n" + lives;
        }

        private static void createUserInterface()
        {
            // Set the limits of the playable zone of the game window (because of sidebars)
            leftMargin = 170;
            rightMargin = GameWindow.ClientRectangle.Width - 170;

            // Left sidebar
            leftSideBar = new PictureBox();
            leftSideBar.Size = new Size(170, GameWindow.ClientRectangle.Height);
            leftSideBar.Location = new Point(0, 0);
            leftSideBar.BackColor = Color.FromArgb(20, 20, 20);
            GameWindow.Controls.Add(leftSideBar);

            // Right sidebar
            rightSideBar = new PictureBox();
            rightSideBar.Size = new Size(170, GameWindow.ClientRectangle.Height);
            rightSideBar.Location = new Point(GameWindow.ClientRectangle.Width - rightSideBar.Size.Width, 0);
            rightSideBar.BackColor = Color.FromArgb(20, 20, 20);
            GameWindow.Controls.Add(rightSideBar);

            // Score label
            scoreLabel = new Label();
            scoreLabel.SetBounds(rightMargin + 20, 20, 150, 120);
            scoreLabel.BackColor = Color.FromArgb(20, 20, 20);
            scoreLabel.ForeColor = Color.Yellow;
            scoreLabel.Font = new Font("Impact", 30);
            GameWindow.Controls.Add(scoreLabel);
            scoreLabel.BringToFront();

            // Lives label
            livesLabel = new Label();
            livesLabel.SetBounds(rightMargin + 20, scoreLabel.Bottom, 150, 60);
            livesLabel.BackColor = Color.FromArgb(20, 20, 20);
            livesLabel.Font = new Font("Impact", 14);
            GameWindow.Controls.Add(livesLabel);
            livesLabel.BringToFront();

            // Instruction labels
            instructionsLabel = new Label();
            instructionsLabel.Text =
                "Try to get the highest score\n\n" +
                "-----------------------\n\n" +
                "Press 'SPACE' button to start!\n\n" +
                "Use Key Pads to control the player!\n\n" +
                "Destroy all blocks to win!\n\n" +
                "Each block:\n+10 points!";
            instructionsLabel.SetBounds(20, 20, 150, GameWindow.Height - 20);
            instructionsLabel.BackColor = Color.FromArgb(20, 20, 20);
            instructionsLabel.Font = new Font("Impact", 15);
            GameWindow.Controls.Add(instructionsLabel);
            instructionsLabel.BringToFront();
        }

        private static void createLevelLayouts()
        {
            /* Matrix representing block positions and types
             * '1' = beige block
             * '2' = red block
             * '3' = blue block
             * '4' = orange block
            */
            levels = new List<char[,]>() {
                new char[20, 22] {
                    {'2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2'},
                    {'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1'},
                    {'2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2'},
                    {'3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3'},
                    {'4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4'},
                    {'3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3'},
                    {'2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2'},
                    {'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1'},
                    {'2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2'},
                    {'3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3'},
                    {'4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4'},
                    {'3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3'},
                    {'2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2'},
                    {'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1'},
                    {'2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2'},
                    {'3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3'},
                    {'4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4','4'},
                    {'3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3','3'},
                    {'2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2','2'},
                    {'1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1'},
                },
            };
        }

        private static void createBlocks()
        {
            // Draw the blocks on the Game Window matching the type and position defined in the level layout matrix
            blocks = new List<Block>();
            for (int i = 0; i < levels[currentLevel].GetLength(0); i++)
            {
                for (int j = 0; j < levels[currentLevel].GetLength(1); j++)
                {
                    char blockType = levels[currentLevel][i, j]; // Get the block type
                    if (blockType != ' ')
                    {
                        // Create the block object and add it to the list of active blocks
                        Block block = new Block(blockType);
                        block.Location = new Point(j + j * block.Size.Width + leftMargin, i + i * block.Size.Height);
                        blocks.Add(block);
                    }
                }
            }
        }

        private static void createNewBall()
        {
            // Create a new ball object and position it on top of the player
            ball = new Ball();
            ball.Location = new Point(
                player.Location.X + player.Size.Width / 2 - ball.Size.Width / 2,
                player.Location.Y - ball.Size.Height);
        }
        
        private static void generateHighscores()
        {
            scores = new Score[80];
            Random r = new Random();
            char[] consonants = { 'b', 'c', 'd', 'f', 'g', 'h', 'k', 'l', 'm', 'n', 'p', 'r', 's', 't', 'y', 'z', 'x', 'w', 'q' };
            char[] vowels = {'a', 'e', 'i', 'o', 'u'};
            for (int i = 0; i < scores.Length; i++)
            {
                // Generate a name composed of 4 characters (alternating between vowels and consonants)
                string name = consonants[r.Next(0, consonants.Length)].ToString() +
                              vowels[r.Next(0, vowels.Length)].ToString() +
                              consonants[r.Next(0, consonants.Length)].ToString() +
                              vowels[r.Next(0, vowels.Length)].ToString();
                score = r.Next(0, 300);
                scores[i] = new Score(score, name.ToUpper());
            }
        }

        private static void startGame()
        {
            // Reset variables
            lives = 3;
            score = 0;

            // Create the blocks for the current level
            createBlocks();

            // Create the player object
            player = new Player();

            // Create a new ball
            createNewBall();
            
            // Bind events
            GameWindow.KeyDown += event_keyDown;
            GameWindow.KeyUp += event_keyUp;
            
            // Start timers
            movementTimer.Start();
            scoreTimer.Start();
        }

        private static void endGame()
        {
            
            // Unbind events
            GameWindow.KeyDown -= event_keyDown;
            GameWindow.KeyUp -= event_keyUp;
            
            // Stop timers
            movementTimer.Stop();
            scoreTimer.Stop();

            livesLabel.Hide();
            createEndgameInterface();
        }

        private static void createEndgameInterface()
        {
            // Create textbox to enter name of the player
            submitScoreTextBox = new TextBox();
            submitScoreTextBox.SetBounds(rightMargin + 20, scoreLabel.Bottom, 130, 30);
            submitScoreTextBox.BackColor = Color.White;
            submitScoreTextBox.Font = new Font("Impact", 16);
            submitScoreTextBox.BorderStyle = BorderStyle.None;
            submitScoreTextBox.TextAlign = HorizontalAlignment.Center;
            GameWindow.Controls.Add(submitScoreTextBox);
            submitScoreTextBox.BringToFront();

            // Create "Submit score" label
            submitScoreLabel = new Label();
            submitScoreLabel.Text = "Submit score!";
            submitScoreLabel.SetBounds(rightMargin + 20, submitScoreTextBox.Bottom + 10, 130, 30);
            submitScoreLabel.BackColor = Color.GreenYellow;
            submitScoreLabel.ForeColor = Color.Black;
            submitScoreLabel.Font = new Font("Impact", 16);
            submitScoreLabel.TextAlign = ContentAlignment.TopCenter;
            submitScoreLabel.Cursor = Cursors.Hand;
            GameWindow.Controls.Add(submitScoreLabel);
            submitScoreLabel.BringToFront();
            submitScoreLabel.Click += submitScoreLabel_Click;

            // Create highscores table
            highscoresTable = new DataGridView();
            highscoresTable.SetBounds(rightMargin, submitScoreLabel.Bottom + 10, 170, 390);
            highscoresTable.BackgroundColor = Color.FromArgb(20, 20, 20);
            highscoresTable.ForeColor = Color.FromArgb(30, 30, 30);
            highscoresTable.GridColor = Color.FromArgb(20, 20, 20);
            highscoresTable.MultiSelect = false;
            highscoresTable.SelectionMode = DataGridViewSelectionMode.FullRowSelect;
            highscoresTable.ColumnHeadersHeightSizeMode = DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            highscoresTable.AllowUserToDeleteRows = false;
            highscoresTable.AllowUserToAddRows = false;
            highscoresTable.AllowUserToOrderColumns = false;
            highscoresTable.AllowUserToResizeColumns = false;
            highscoresTable.AllowUserToResizeRows = false;
            highscoresTable.RowHeadersVisible = false;
            highscoresTable.AutoGenerateColumns = false;
            highscoresTable.AutoSize = false;
            highscoresTable.ReadOnly = true;
            highscoresTable.Columns.Add("Score", "Score");
            highscoresTable.Columns.Add("Name", "Name");
            highscoresTable.Columns[0].AutoSizeMode = DataGridViewAutoSizeColumnMode.Fill;
            highscoresTable.Columns[0].DefaultCellStyle.Font = new Font("Impact", 10);
            highscoresTable.Columns[1].DefaultCellStyle.Font = new Font("Impact", 10);
            highscoresTable.Columns[0].SortMode = DataGridViewColumnSortMode.NotSortable;
            highscoresTable.Columns[1].SortMode = DataGridViewColumnSortMode.NotSortable;
            /* Sort and insert the highscores into the table */
            sortHighscores();
            insertHighscores();
            GameWindow.Controls.Add(highscoresTable);
            highscoresTable.BringToFront();

            // Create "Restart game" label
            restartGameLabel = new Label();
            restartGameLabel.Text = "Restart Game";
            restartGameLabel.SetBounds(rightMargin + 20, GameWindow.ClientRectangle.Height - 60, 130, 30);
            restartGameLabel.BackColor = Color.OrangeRed;
            restartGameLabel.Font = new Font("Impact", 16);
            restartGameLabel.TextAlign = ContentAlignment.TopCenter;
            restartGameLabel.Cursor = Cursors.Hand;
            GameWindow.Controls.Add(restartGameLabel);
            restartGameLabel.BringToFront();
            restartGameLabel.Click += restartGameLabel_Click;
        }

        private static void submitScoreLabel_Click(Object myObject, EventArgs myEventArgs)
        {
            scores[scores.Length-1] = new Score(score, submitScoreTextBox.Text);
            sortHighscores();
            insertHighscores();

            submitScoreTextBox.Hide();
            submitScoreLabel.Hide();

            // Create textbox to find the score
            findScoreTextBox = new TextBox();
            findScoreTextBox.SetBounds(rightMargin + 20, scoreLabel.Bottom, 130, 30);
            findScoreTextBox.BackColor = Color.White;
            findScoreTextBox.Font = new Font("Impact", 16);
            findScoreTextBox.BorderStyle = BorderStyle.None;
            findScoreTextBox.TextAlign = HorizontalAlignment.Center;
            GameWindow.Controls.Add(findScoreTextBox);
            findScoreTextBox.BringToFront();

            // Create "Find score" label
            findScoreLabel = new Label();
            findScoreLabel.Text = "Search!";
            findScoreLabel.SetBounds(rightMargin + 20, findScoreTextBox.Bottom + 10, 130, 30);
            findScoreLabel.BackColor = Color.SkyBlue;
            findScoreLabel.ForeColor = Color.Black;
            findScoreLabel.Font = new Font("Impact", 16);
            findScoreLabel.TextAlign = ContentAlignment.TopCenter;
            findScoreLabel.Cursor = Cursors.Hand;
            GameWindow.Controls.Add(findScoreLabel);
            findScoreLabel.BringToFront();
            findScoreLabel.Click += findScoreLabel_Click;
        }

        private static void findScoreLabel_Click(Object myObject, EventArgs myEventArgs)
        {
            if (findScoreTextBox.Text != string.Empty)
            {
                int position = findScorePosition(Int32.Parse(findScoreTextBox.Text));
                if (position > -1)
                {
                    highscoresTable.ClearSelection();
                    highscoresTable.Rows[position].Selected = true;
                    highscoresTable.FirstDisplayedScrollingRowIndex = position;
                }
            }
        }

        private static void restartGameLabel_Click(Object myObject, EventArgs myEventArgs)
        {
            restartGameLabel.Hide();
            submitScoreLabel.Hide();
            highscoresTable.Hide();
            if (findScoreLabel is Label) findScoreLabel.Hide();
            GameWindow.Controls.Remove(submitScoreTextBox);
            GameWindow.Controls.Remove(findScoreTextBox);
            GameWindow.Controls.Remove(ball);
            GameWindow.Controls.Remove(player);
            
            foreach (Block b in blocks) GameWindow.Controls.Remove(b);
            blocks.Clear();
            livesLabel.Show();
            startGame();
        }

        private static void sortHighscores()
        {
            bool sorted = false;
            while (!sorted)
            {
                sorted = true;
                for (int i = 0; i < scores.Length-1; i++)
                {
                    if (scores[i].score < scores[i + 1].score)
                    {
                        Score tmp = scores[i];
                        scores[i] = scores[i + 1];
                        scores[i + 1] = tmp;
                        sorted = false;
                    }
                }
            }
        }

        private static void insertHighscores()
        {
            // Insert the scores into the table
            highscoresTable.Rows.Clear();
            for (int i = 0; i < scores.Length; i++)
            {
                highscoresTable.Rows.Add(new String[] { scores[i].score.ToString(), scores[i].name });
                if (score == scores[i].score && submitScoreTextBox.Text == scores[i].name)
                    highscoresTable.Rows[i].DefaultCellStyle.ForeColor = Color.OrangeRed;
            }
        }

        private static int findScorePosition(int score)
        {
            int min = 0;
            int max = scores.Length - 1;
            int cur = 0;
 
            while (min <= max)
            {
                cur = (max - min) / 2 + min;
                if (score == scores[cur].score)
                {
                    return cur;
                }
                else if (score > scores[cur].score)
                    max = cur - 1;
                else
                    min = cur + 1;
            }
 
            return -1;
        }
    }
}