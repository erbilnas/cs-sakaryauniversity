using System.Drawing;
using System.Windows.Forms;

namespace BaseGame
{
    class Block : PictureBox
    {
        public char type;

        public Block(char blockType)
        {
            this.type = blockType;
            this.Size = new Size(48, 18);
            this.Image = new Bitmap(Image.FromFile("Resources/block_" + blockType + ".png"), this.Size);
            Program.GameWindow.Controls.Add(this);
        }
    }
}