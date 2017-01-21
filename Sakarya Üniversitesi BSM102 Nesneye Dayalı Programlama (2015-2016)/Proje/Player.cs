using System.Drawing;
using System.Windows.Forms;

namespace BaseGame
{
    class Player : PictureBox
    {
        public int moveSpeed = 10;
        public int horizontalAxis;
        public bool isMovingLeft = false;
        public bool isMovingRight = false;

        public Player()
        {
            this.Size = new Size(64, 18);
            this.SizeMode = PictureBoxSizeMode.StretchImage;
            // Center the player at the bottom of the game window
            this.horizontalAxis = Program.GameWindow.Height - this.Size.Height - 60;
            this.Location = new Point(Program.GameWindow.ClientRectangle.Width / 2 - this.Size.Width / 2, this.horizontalAxis);
            this.Image = new Bitmap(Image.FromFile("Resources/player.png"));
            Program.GameWindow.Controls.Add(this);
            this.BringToFront();
        }

        public void moveLeft()
        {
            this.Location = new Point(this.Location.X - this.moveSpeed, this.horizontalAxis);
        }

        public void moveRight()
        {
            this.Location = new Point(this.Location.X + this.moveSpeed, this.horizontalAxis);
        }
    }
}