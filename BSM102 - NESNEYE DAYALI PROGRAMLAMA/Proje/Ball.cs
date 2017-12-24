using System.Drawing;
using System.Windows.Forms;

namespace BaseGame
{
    class Ball : PictureBox
    {
        public Point speed = new Point(2, -8);
        public bool launched = false;

        public Ball()
        {
            this.Size = new Size(16, 16);
            this.Image = new Bitmap(Image.FromFile("Resources/ball.png"), this.Size);
            Program.GameWindow.Controls.Add(this);
        }

        public void move()
        {
            this.Location = new Point(this.Location.X + this.speed.X, this.Location.Y + this.speed.Y);
        }

        public void flipX()
        {
            this.speed.X *= -1;
        }

        public void flipY()
        {
            this.speed.Y *= -1;
        }

        public bool collision(PictureBox obj)
        {
            bool collided = false;

            // I will be using the center points of the borders of the ball to check the collisions
            Point topCenter = new Point(this.Location.X + this.Size.Width / 2, this.Location.Y);
            Point bottomCenter = new Point(this.Location.X + this.Size.Width / 2, this.Location.Y + this.Size.Height);
            Point leftCenter = new Point(this.Location.X, this.Location.Y + this.Size.Height / 2);
            Point rightCenter = new Point(this.Location.X + this.Size.Width, this.Location.Y + this.Size.Height / 2);

            // Collision from left side of the ball
            if (leftCenter.Y >= obj.Location.Y &&
                leftCenter.Y <= obj.Location.Y + obj.Size.Height &&
                leftCenter.X >= obj.Location.X &&
                leftCenter.X <= obj.Location.X + obj.Width)
            {
                /* In this case, if the left side of the ball collides while the ball is moving left, flip its direction else, move it at maximum horizontal speed in the same direction (simulating a corner collision) */
                if (this.speed.X < 0) this.flipX();
                else this.speed.X = 8;

                collided = true;
            }

            // Collision from right side of the ball
            else if (rightCenter.Y >= obj.Location.Y &&
                rightCenter.Y <= obj.Location.Y + obj.Size.Height &&
                rightCenter.X >= obj.Location.X &&
                rightCenter.X <= obj.Location.X + obj.Width)
            {
                if (this.speed.X > 0) this.flipX();
                else this.speed.X = -8;

                collided = true;
            }

            // Collision from top side of the ball
            else if (topCenter.X >= obj.Location.X &&
                topCenter.X <= obj.Location.X + obj.Size.Width &&
                topCenter.Y >= obj.Location.Y &&
                topCenter.Y <= obj.Location.Y + obj.Height)
            {
                if (this.speed.Y < 0) this.flipY();
                else this.speed.Y = 8;

                collided = true;
            }

            // Collision from bottom side of the ball
            else if (bottomCenter.X >= obj.Location.X &&
                bottomCenter.X <= obj.Location.X + obj.Size.Width &&
                bottomCenter.Y >= obj.Location.Y &&
                bottomCenter.Y <= obj.Location.Y + obj.Height)
            {
                if (this.speed.Y > 0) this.flipY();
                else this.speed.Y = -8;
                
                collided = true;

                // If the ball hits the player
                if (obj is Player)
                {
                    float surfaceHit = 0;
                    // Determine where in the player surface the ball has hit (from 0 to 100) and change its new angle
                    surfaceHit = (bottomCenter.X - obj.Location.X) / (float)obj.Size.Width * 100;
                    if (surfaceHit >= 0 && surfaceHit < 15) this.speed.X = -4;  // Hit at the left, ball goes at an angle to the left
                    else if (surfaceHit >= 15 && surfaceHit < 25) this.speed.X = -3;
                    else if (surfaceHit >= 25 && surfaceHit < 35) this.speed.X = -2;
                    else if (surfaceHit >= 35 && surfaceHit < 49) this.speed.X = -1;
                    else if (surfaceHit >= 49 && surfaceHit <= 51) this.speed.X = 0; // Hit at the center, ball goes straight up
                    else if (surfaceHit > 51 && surfaceHit <= 65) this.speed.X = 1;
                    else if (surfaceHit > 65 && surfaceHit <= 75) this.speed.X = 2;
                    else if (surfaceHit > 75 && surfaceHit <= 85) this.speed.X = 3;
                    else if (surfaceHit > 85 && surfaceHit <= 100) this.speed.X = 4; // Hit at the right, ball goes at an angle to the right
                }
            }
            return collided;
        }
    }
}