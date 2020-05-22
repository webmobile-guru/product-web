using System.IO;
using System.Net;
using System.Net.NetworkInformation;
using System.Net.Sockets;
using System.Windows;

namespace RouletteSimulator.Views
{
    /// <summary>
    /// The RouletteSimulatorView class represents the view for the Roulette Simulator.
    /// </summary>
    public partial class RouletteSimulatorView : Window
    {
        #region Fields
        #endregion

        #region Constructors

        /// <summary>
        /// Default constructor.
        /// </summary>
        public RouletteSimulatorView()
        {
            InitializeComponent();

        }

        #endregion

        #region Events
        #endregion

        #region Properties
        #endregion

        #region Methods

        private void focusTextStatus(object sender, RoutedEventArgs e)
        {
            if (licensekey.IsFocused)
            {
                licensekey.Text = "";
            }
        }
        private void userTextStatus(object sender, RoutedEventArgs e)
        {
            if (username.IsFocused)
            {
                username.Text = "";
            }
        }

        public void flag_recognise(object sender, RoutedEventArgs e)
        {
            /*
            string path = @"C:\Users\Public\flag.dll";
            if (File.Exists(path))
            {
                using (StreamReader sr = File.OpenText(path))
                {
                    string s = "";
                    string flags = "";
                    int i = 0;
                    while ((s = sr.ReadLine()) != null)
                    {
                        flags = s;
                        i++;
                    }
                    if (flags == "1")
                    {
                        MessageBox.Show("forever");
                    }
                    else
                    {
                        MessageBox.Show("no licence");
                    }
                }
            }
            else
            {
                MessageBox.Show("no file exist");
            }*/



            
            /*
            string path_f = @"C:\Users\Public\roulette";
            bool exists = System.IO.Directory.Exists(path_f);
            if (!exists)
            {
                System.IO.Directory.CreateDirectory(path_f);
            }
            */

            
             string path_username = @"C:\Users\Public\username.inf";
            if (!File.Exists(path_username))
            {
                using (System.IO.StreamWriter file = new System.IO.StreamWriter(path_username))
                {
                    file.WriteLine("");
                }
            }

            string path_userlicense = @"C:\Users\Public\userlicense.inf";
            if (!File.Exists(path_userlicense))
            {
                using (System.IO.StreamWriter file = new System.IO.StreamWriter(path_userlicense))
                {
                    file.WriteLine("");
                }
            }

        }


        #endregion
    }
}
