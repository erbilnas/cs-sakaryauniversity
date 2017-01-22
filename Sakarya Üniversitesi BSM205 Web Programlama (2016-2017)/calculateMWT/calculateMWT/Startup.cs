using Microsoft.Owin;
using Owin;

[assembly: OwinStartupAttribute(typeof(calculateMWT.Startup))]
namespace calculateMWT
{
    public partial class Startup
    {
        public void Configuration(IAppBuilder app)
        {
            ConfigureAuth(app);
        }
    }
}
