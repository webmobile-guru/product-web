using LicenceApp;
using Prism.Commands;
using Prism.Events;
using Prism.Mvvm;
using RouletteSimulator.Core.EventAggregator;
using System;
using System.Globalization;
using System.IO;
using System.Net;
using System.Net.Cache;
using System.Net.Http;
using System.Net.NetworkInformation;
using System.Text.RegularExpressions;
using System.Threading;
using System.Windows;
using System.Windows.Threading;

namespace RouletteSimulator.ViewModels
{
    /// <summary>
    /// The RouletteSimulatorViewModel class represents the view model for the Roulette Simulator.
    /// </summary>
    public class RouletteSimulatorViewModel : BindableBase
    {
        #region Fields
        IEventAggregator _ea;
        #endregion

        DispatcherTimer _v_timer;
        int progress_v;
        HttpClient httpClient = new HttpClient();

        string visible_loading = "hidden";
        String visible_image = "hidden";

        //FOR HELP PAGE
        string visible_help_image = "hidden";
        string visible_help_button = "hidden";
        //for lisence
        string lisence_text_visible = "hidden";
        string lisence_sid_visible = "hidden";
        string lisence_name_visible = "hidden";
        string lisence_button_visible = "hidden";
        string lisence_image_visible = "hidden";

        string lisence_key_visible = "visible";
        //lisence key click publish
        public DelegateCommand Lisence_key
        {
            get;
            private set;
        }
        public DelegateCommand Lisence_button_command
        {
            get;
            private set;
        }

        private string _lisence_key = "Please input the license key";
        public string Lisence_input
        {
            get { return _lisence_key; }
            set { SetProperty(ref _lisence_key, value); }
        }
        //for licence_name
        private string _lisence_name_key = "Please input the User name.";
        public string Lisence_name_input
        {
            get { return _lisence_name_key; }
            set { SetProperty(ref _lisence_name_key, value); }
        }
        //for licence_sid
        private string _lisence_sid_key = "your sid";
        public string Lisence_sid_input
        {
            get { return _lisence_sid_key; }
            set { SetProperty(ref _lisence_sid_key, value); }
        }
        //lisence end


        public string HELP_IMAGE_VISIBLE
        {
            get { return visible_help_image; }
            set { SetProperty(ref visible_help_image, value); }
        }
        public string HELP_BUTTON_VISIBLE
        {
            get { return visible_help_button; }
            set { SetProperty(ref visible_help_button, value); }
        }
        public string Lisence_text_visible
        {
            get { return lisence_text_visible; }
            set { SetProperty(ref lisence_text_visible, value); }
        }
        public string Lisence_sid_visible
        {
            get { return lisence_sid_visible; }
            set { SetProperty(ref lisence_sid_visible, value); }
        }
        public string Lisence_name_visible
        {
            get { return lisence_name_visible; }
            set { SetProperty(ref lisence_name_visible, value); }
        }
        public string Lisence_button_visible
        {
            get { return lisence_button_visible; }
            set { SetProperty(ref lisence_button_visible, value); }
        }
        public string Lisence_image_visible
        {
            get { return lisence_image_visible; }
            set { SetProperty(ref lisence_image_visible, value); }
        }
        public string Lisence_key_visible
        {
            get { return lisence_key_visible; }
            set { SetProperty(ref lisence_key_visible, value); }
        }

        //for Help view close
        public DelegateCommand HELPCOLOSE
        {
            get;
            private set;
        }


        int loading_value;

        public string VISIBLE_IMAGE
        {
            get { return visible_image; }
            set
            {
                SetProperty(ref visible_image, value);
            }
        }
        public string VISIBLE_LOADING
        {
            get { return visible_loading; }
            set
            {
                SetProperty(ref visible_loading, value);
            }
        }

        public int LOADING
        {
            get { return loading_value; }
            set
            {
                SetProperty(ref loading_value, value);
            }
        }

        #region Constructors
        public DelegateCommand predict_btn
        {
            get;
            private set;
        }
        public DelegateCommand reset_btn
        {
            get;
            private set;
        }
        public DelegateCommand back_btn
        {
            get;
            private set;
        }
        public DelegateCommand Help_show
        {
            get;
            private set;
        }

        /// <summary>
        /// Default constructor.
        /// </summary>
        public RouletteSimulatorViewModel(IEventAggregator ea)
        {
            _ea = ea;
            predict_btn = new DelegateCommand(Event_predict);
            reset_btn = new DelegateCommand(Event_reset);
            back_btn = new DelegateCommand(Event_back);
            Help_show = new DelegateCommand(Event_Help_show);
            HELPCOLOSE = new DelegateCommand(Event_Help_close);
            Lisence_key = new DelegateCommand(Event_Lisence);
            Lisence_button_command = new DelegateCommand(Event_Okay_Lisence);

            ea.GetEvent<Button_Event>().Subscribe(Progressing);
            ea.GetEvent<Button_Event>().Subscribe(Help_View);
        }

        private void Event_Okay_Lisence()
        {
            Thread.Sleep(2000);

            //string a = Lisence_input;

            //string PIDRoot = "edafb1d0-e0b6-42e5-a2b4-09339097348b";
            //string PId = "188314dd-9fc6-49a6-a93f-0730d8291166";
            // string Email = "Bncm888@gmail.com";
            string PIDRoot = "67438fee-89b1-4456-bdc9-24067fb86491";
            string PId = Lisence_input;
            string Email = Lisence_name_input;

           /*
            string path_flag = @"C:\Users\Public\flag.dll";
            if (File.Exists(path_flag))
            {
                using (StreamReader sr = File.OpenText(path_flag))
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
                        // MessageBox.Show("forever");
                    }
                    else
                    {
                        // MessageBox.Show("no licence");
                    }
                }
            }
            */
            if (LicenceApp.Licence.CheckProduct(Email, PId, PIDRoot))
            {

                Lisence_text_visible = "hidden";
                Lisence_button_visible = "hidden";
                Lisence_image_visible = "hidden";
                Lisence_sid_visible = "hidden";
                Lisence_name_visible = "hidden";
                Lisence_key_visible = "hidden";

                MessageBox.Show("Successfully!");

                string path = @"C:\Users\Public\flag.dll";
                if (File.Exists(path))
                {
                    using (System.IO.StreamWriter file = new System.IO.StreamWriter(path))
                    {
                        file.WriteLine("1");
                    }
                }

            }
            else
            {
                MessageBox.Show("Wrong value. Please try again.");
                string path = @"C:\Users\Public\flag.dll";
                if (File.Exists(path))
                {
                    using (System.IO.StreamWriter file = new System.IO.StreamWriter(path))
                    {
                        file.WriteLine("0");
                    }
                }
            }
        }
        private void Event_Lisence()
        {
            Lisence_text_visible = "visible";
            Lisence_button_visible = "visible";
            Lisence_image_visible = "visible";
            Lisence_sid_visible = "visible";
            Lisence_name_visible = "visible";

            Lisence_sid_input = Licence.GetSerialNo();
            //_ea.GetEvent<>
            //Page1 lisence_view = new Page1();
            //lisence_view.ShowsNavigationUI();
        }
        private void Help_View(string parameter)
        {
            if (parameter == "Event_Help_show")
            {
                HELP_BUTTON_VISIBLE = "visible";
                HELP_IMAGE_VISIBLE = "visible";
            }
        }
        private void Event_Help_show()
        {
            _ea.GetEvent<Button_Event>().Publish("Event_Help_show");
        }
        //publish close event
        private void Event_Help_close()
        {
            HELP_BUTTON_VISIBLE = "hidden";
            HELP_IMAGE_VISIBLE = "hidden";
            //_ea.GetEvent<Button_Event>().Publish("Event_Help_close");
        }

        //subscribe close event
        string _HELPCOLOSE;
        // public string HELPCOLOSE()
        //  {

        // }

        private void Progressing(string parameter)
        {
            if (parameter == "Event_predict")
            {

                bool con = NetworkInterface.GetIsNetworkAvailable();
                if (con == true)
                {
                    //MessageBox.Show("online");
                    VISIBLE_LOADING = "Visible";
                    VISIBLE_IMAGE = "Visible";

                    //string path_flag = @"C:\Users\Public\flag.dll";
                 //   if (File.Exists(path_flag))
                 //   {
                 //       using (StreamReader sr_flag = File.OpenText(path_flag))
                 //       {
                  //          string s_flag = "";
                  //          string flags = "";
                   //         int i_flag = 0;
                   //         while ((s_flag = sr_flag.ReadLine()) != null)
                   //         {
                   //             flags = s_flag;
                   //             i_flag++;
                   //         }
                           /* if (flags == "1")
                            {
                                //MessageBox.Show("forever");
                                progress_v = 0;

                                _v_timer = new DispatcherTimer();
                                _v_timer.Tick += (Progress_values);
                                _v_timer.Interval += new System.TimeSpan(0, 0, 0, 0, 1);
                                _v_timer.Start();

                            }*/
                            //else
                            {
                            //MessageBox.Show("no licence");

                            // string path = @"C:\Users\Public\desktop.dll";
                            //   if (!File.Exists(path))
                            ////   {
                            //      using (System.IO.StreamWriter file = new System.IO.StreamWriter(path))
                            ////      {
                            //          file.WriteLine(GetNistTime().ToString("HHmm"));
                            //       }
                            //   }
                            string path = @"C:\Users\Public\roulette\userinfo.dll";
                            if (File.Exists(path))
                                {
                                    // Open the file to read from.
                                    using (StreamReader sr = File.OpenText(path))
                                    {
                                        string s = "";
                                        string start_date = "";
                                        int i = 0;
                                        while ((s = sr.ReadLine()) != null)
                                        {
                                            start_date = s;
                                            i++;
                                        }
                                        int timer_past = Int32.Parse(start_date);
                                        int timer_current = Int32.Parse(GetNistTime().ToString("HHmm"));

                                        if (timer_current < timer_past + 0)
                                        {
                                            progress_v = 0;

                                            _v_timer = new DispatcherTimer();
                                            _v_timer.Tick += (Progress_values);
                                            _v_timer.Interval += new System.TimeSpan(0, 0, 0, 0, 1);
                                            _v_timer.Start();
                                        }
                                        else
                                        {
                                            Lisence_text_visible = "visible";
                                            Lisence_button_visible = "visible";
                                            Lisence_image_visible = "visible";
                                            Lisence_sid_visible = "visible";
                                            Lisence_name_visible = "visible";
                                            Lisence_sid_input = Licence.GetSerialNo();

                                            VISIBLE_IMAGE = "hidden";
                                            VISIBLE_LOADING = "Hidden";
                                            progress_v = 0;
                                        }

                                    }
                                }
                            }
                        }
                  //  }
                  //  else
                  //  {
                   //     Lisence_text_visible = "visible";
                   //     Lisence_button_visible = "visible";
                  //      Lisence_image_visible = "visible";
                  ///      Lisence_sid_visible = "visible";
                  //      Lisence_name_visible = "visible";
                  //      Lisence_sid_input = Licence.GetSerialNo();
                  //
                   ////     VISIBLE_IMAGE = "hidden";
                   //     VISIBLE_LOADING = "Hidden";
                   //     progress_v = 0;
                  //  }
               // }
                else
                {
                    MessageBox.Show("I can't use this software on offline. Please connect Network.");
                }


            }
        }

        //get the internet time
        public static DateTime GetNistTime()
        {
            try
            {
                using (var response =
                  WebRequest.Create("http://www.google.com").GetResponse())
                    //string todaysDates =  response.Headers["date"];
                    return DateTime.ParseExact(response.Headers["date"],
                        "ddd, dd MMM yyyy HH:mm:ss 'GMT'",
                        CultureInfo.InvariantCulture.DateTimeFormat,
                        DateTimeStyles.AssumeUniversal);
            }
            catch (WebException)
            {
                return DateTime.Now; //In case something goes wrong. 
            }
        }

        private void Event_predict()
        {
            _ea.GetEvent<Button_Event>().Publish("Event_predict");
        }

        private void Event_reset()
        {
            _ea.GetEvent<Button_Event>().Publish("Event_reset");
        }
        private void Event_back()
        {
            _ea.GetEvent<Button_Event>().Publish("Event_back");
        }
        private void Progress_values(object sender, EventArgs e)
        {
            LOADING = progress_v;
            progress_v++;
            if (progress_v > 100)
            {
                VISIBLE_IMAGE = "hidden";
                VISIBLE_LOADING = "Hidden";
                Lisence_key_visible = "hidden";
                progress_v = 0;
                _v_timer.Stop();
            }
            Thread.Sleep(10);
        }
        #endregion

        #region Events
        #endregion

        #region Properties
        #endregion

        #region Methods
        #endregion
    }
}
