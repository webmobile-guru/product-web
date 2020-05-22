using Prism.Events;
using Prism.Mvvm;
using RouletteSimulator.Core.Enumerations;
using RouletteSimulator.Core.EventAggregator;
using RouletteSimulator.Core.Models.BoardModels;
using RouletteSimulator.Core.Models.WheelModels;
using System.Windows.Media;

namespace Show.ViewModels
{
    public class ShowViewModel : BindableBase
    {
        IEventAggregator _ea;
        int index;
        string[] background_back = new string[1000];

        Brush _BACKGOURNDCOLOR0,
            _BACKGOURNDCOLOR1, _BACKGOURNDCOLOR2, _BACKGOURNDCOLOR3, _BACKGOURNDCOLOR4, _BACKGOURNDCOLOR5,
            _BACKGOURNDCOLOR6, _BACKGOURNDCOLOR7, _BACKGOURNDCOLOR8, _BACKGOURNDCOLOR9, _BACKGOURNDCOLOR10,
            _BACKGOURNDCOLOR11, _BACKGOURNDCOLOR12, _BACKGOURNDCOLOR13, _BACKGOURNDCOLOR14, _BACKGOURNDCOLOR15,
            _BACKGOURNDCOLOR16, _BACKGOURNDCOLOR17, _BACKGOURNDCOLOR18, _BACKGOURNDCOLOR19, _BACKGOURNDCOLOR20,
            _BACKGOURNDCOLOR21, _BACKGOURNDCOLOR22, _BACKGOURNDCOLOR23, _BACKGOURNDCOLOR24, _BACKGOURNDCOLOR25,
            _BACKGOURNDCOLOR26, _BACKGOURNDCOLOR27, _BACKGOURNDCOLOR28, _BACKGOURNDCOLOR29, _BACKGOURNDCOLOR30,
            _BACKGOURNDCOLOR31, _BACKGOURNDCOLOR32, _BACKGOURNDCOLOR33, _BACKGOURNDCOLOR34, _BACKGOURNDCOLOR35, _BACKGOURNDCOLOR36;
        public Brush BACKGOURNDCOLOR0
        {
            get { return _BACKGOURNDCOLOR0; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR0, value);
            }
        }
        public Brush BACKGOURNDCOLOR1
        {
            get { return _BACKGOURNDCOLOR1; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR1, value);
            }
        }
        public Brush BACKGOURNDCOLOR2
        {
            get { return _BACKGOURNDCOLOR2; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR2, value);
            }
        }
        public Brush BACKGOURNDCOLOR3
        {
            get { return _BACKGOURNDCOLOR3; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR3, value);
            }
        }
        public Brush BACKGOURNDCOLOR4
        {
            get { return _BACKGOURNDCOLOR4; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR4, value);
            }
        }
        public Brush BACKGOURNDCOLOR5
        {
            get { return _BACKGOURNDCOLOR5; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR5, value);
            }
        }
        public Brush BACKGOURNDCOLOR6
        {
            get { return _BACKGOURNDCOLOR6; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR6, value);
            }
        }
        public Brush BACKGOURNDCOLOR7
        {
            get { return _BACKGOURNDCOLOR7; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR7, value);
            }
        }
        public Brush BACKGOURNDCOLOR8
        {
            get { return _BACKGOURNDCOLOR8; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR8, value);
            }
        }
        public Brush BACKGOURNDCOLOR9
        {
            get { return _BACKGOURNDCOLOR9; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR9, value);
            }
        }
        public Brush BACKGOURNDCOLOR10
        {
            get { return _BACKGOURNDCOLOR10; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR10, value);
            }
        }
        public Brush BACKGOURNDCOLOR11
        {
            get { return _BACKGOURNDCOLOR11; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR11, value);
            }
        }
        public Brush BACKGOURNDCOLOR12
        {
            get { return _BACKGOURNDCOLOR12; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR12, value);
            }
        }
        public Brush BACKGOURNDCOLOR13
        {
            get { return _BACKGOURNDCOLOR13; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR13, value);
            }
        }
        public Brush BACKGOURNDCOLOR14
        {
            get { return _BACKGOURNDCOLOR14; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR14, value);
            }
        }
        public Brush BACKGOURNDCOLOR15
        {
            get { return _BACKGOURNDCOLOR15; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR15, value);
            }
        }
        public Brush BACKGOURNDCOLOR16
        {
            get { return _BACKGOURNDCOLOR16; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR16, value);
            }
        }
        public Brush BACKGOURNDCOLOR17
        {
            get { return _BACKGOURNDCOLOR17; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR17, value);
            }
        }
        public Brush BACKGOURNDCOLOR18
        {
            get { return _BACKGOURNDCOLOR18; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR18, value);
            }
        }
        public Brush BACKGOURNDCOLOR19
        {
            get { return _BACKGOURNDCOLOR19; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR19, value);
            }
        }
        public Brush BACKGOURNDCOLOR20
        {
            get { return _BACKGOURNDCOLOR20; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR20, value);
            }
        }
        public Brush BACKGOURNDCOLOR21
        {
            get { return _BACKGOURNDCOLOR21; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR21, value);
            }
        }
        public Brush BACKGOURNDCOLOR22
        {
            get { return _BACKGOURNDCOLOR22; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR22, value);
            }
        }
        public Brush BACKGOURNDCOLOR23
        {
            get { return _BACKGOURNDCOLOR23; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR23, value);
            }
        }
        public Brush BACKGOURNDCOLOR24
        {
            get { return _BACKGOURNDCOLOR24; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR24, value);
            }
        }
        public Brush BACKGOURNDCOLOR25
        {
            get { return _BACKGOURNDCOLOR25; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR25, value);
            }
        }
        public Brush BACKGOURNDCOLOR26
        {
            get { return _BACKGOURNDCOLOR26; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR26, value);
            }
        }
        public Brush BACKGOURNDCOLOR27
        {
            get { return _BACKGOURNDCOLOR27; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR27, value);
            }
        }
        public Brush BACKGOURNDCOLOR28
        {
            get { return _BACKGOURNDCOLOR28; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR28, value);
            }
        }
        public Brush BACKGOURNDCOLOR29
        {
            get { return _BACKGOURNDCOLOR29; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR29, value);
            }
        }
        public Brush BACKGOURNDCOLOR30
        {
            get { return _BACKGOURNDCOLOR30; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR30, value);
            }
        }
        public Brush BACKGOURNDCOLOR31
        {
            get { return _BACKGOURNDCOLOR31; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR31, value);
            }
        }
        public Brush BACKGOURNDCOLOR32
        {
            get { return _BACKGOURNDCOLOR32; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR32, value);
            }
        }
        public Brush BACKGOURNDCOLOR33
        {
            get { return _BACKGOURNDCOLOR33; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR33, value);
            }
        }
        public Brush BACKGOURNDCOLOR34
        {
            get { return _BACKGOURNDCOLOR34; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR34, value);
            }
        }
        public Brush BACKGOURNDCOLOR35
        {
            get { return _BACKGOURNDCOLOR35; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR35, value);
            }
        }
        public Brush BACKGOURNDCOLOR36
        {
            get { return _BACKGOURNDCOLOR36; }
            set
            {
                SetProperty(ref _BACKGOURNDCOLOR36, value);
            }
        }

        public ShowViewModel(IEventAggregator ea)
        {
            _ea = ea;
            ea.GetEvent<Keyboard_Num>().Subscribe(MessageReceived);
            ea.GetEvent<Button_Event>().Subscribe(Event_btn);
        }
        private void MessageReceived(string parameter)
        {
            switch (parameter)
            {
                case "0":
                    index++;
                    background_back[index - 1] = "0";
                    BACKGOURNDCOLOR0 = new SolidColorBrush(Colors.DarkGreen);
                    break;
                case "1":
                    index++;
                    background_back[index - 1] = "1";
                    BACKGOURNDCOLOR1 = new SolidColorBrush(Colors.Red);
                    break;
                case "2":
                    index++;
                    background_back[index - 1] = "2";
                    BACKGOURNDCOLOR2 = new SolidColorBrush(Colors.Black);
                    break;
                case "3":
                    index++;
                    background_back[index - 1] = "3";
                    BACKGOURNDCOLOR3 = new SolidColorBrush(Colors.Red);
                    break;
                case "4":
                    index++;
                    background_back[index - 1] = "4";
                    BACKGOURNDCOLOR4 = new SolidColorBrush(Colors.Black);
                    break;
                case "5":
                    index++;
                    background_back[index - 1] = "5";
                    BACKGOURNDCOLOR5 = new SolidColorBrush(Colors.Red);
                    break;
                case "6":
                    index++;
                    background_back[index - 1] = "6";
                    BACKGOURNDCOLOR6 = new SolidColorBrush(Colors.Black);
                    break;
                case "7":
                    index++;
                    background_back[index - 1] = "7";
                    BACKGOURNDCOLOR7 = new SolidColorBrush(Colors.Red);
                    break;
                case "8":
                    index++;
                    background_back[index - 1] = "8";
                    BACKGOURNDCOLOR8 = new SolidColorBrush(Colors.Black);
                    break;
                case "9":
                    index++;
                    background_back[index - 1] = "9";
                    BACKGOURNDCOLOR9 = new SolidColorBrush(Colors.Red);
                    break;
                case "10":
                    index++;
                    background_back[index - 1] = "10";
                    BACKGOURNDCOLOR10 = new SolidColorBrush(Colors.Black);
                    break;
                case "11":
                    index++;
                    background_back[index - 1] = "11";
                    BACKGOURNDCOLOR11 = new SolidColorBrush(Colors.Black);
                    break;
                case "12":
                    index++;
                    background_back[index - 1] = "12";
                    BACKGOURNDCOLOR12 = new SolidColorBrush(Colors.Red);
                    break;
                case "13":
                    index++;
                    background_back[index - 1] = "13";
                    BACKGOURNDCOLOR13 = new SolidColorBrush(Colors.Black);
                    break;
                case "14":
                    index++;
                    background_back[index - 1] = "14";
                    BACKGOURNDCOLOR14 = new SolidColorBrush(Colors.Red);
                    break;
                case "15":
                    index++;
                    background_back[index - 1] = "15";
                    BACKGOURNDCOLOR15 = new SolidColorBrush(Colors.Black);
                    break;
                case "16":
                    index++;
                    background_back[index - 1] = "16";
                    BACKGOURNDCOLOR16 = new SolidColorBrush(Colors.Red);
                    break;
                case "17":
                    index++;
                    background_back[index - 1] = "17";
                    BACKGOURNDCOLOR17 = new SolidColorBrush(Colors.Black);
                    break;
                case "18":
                    index++;
                    background_back[index - 1] = "18";
                    BACKGOURNDCOLOR18 = new SolidColorBrush(Colors.Red);
                    break;
                case "19":
                    index++;
                    background_back[index - 1] = "19";
                    BACKGOURNDCOLOR19 = new SolidColorBrush(Colors.Red);
                    break;
                case "20":
                    index++;
                    background_back[index - 1] = "20";
                    BACKGOURNDCOLOR20 = new SolidColorBrush(Colors.Black);
                    break;
                case "21":
                    index++;
                    background_back[index - 1] = "21";
                    BACKGOURNDCOLOR21 = new SolidColorBrush(Colors.Red);
                    break;
                case "22":
                    index++;
                    background_back[index - 1] = "22";
                    BACKGOURNDCOLOR22 = new SolidColorBrush(Colors.Black);
                    break;
                case "23":
                    index++;
                    background_back[index - 1] = "23";
                    BACKGOURNDCOLOR23 = new SolidColorBrush(Colors.Red);
                    break;
                case "24":
                    index++;
                    background_back[index - 1] = "24";
                    BACKGOURNDCOLOR24 = new SolidColorBrush(Colors.Black);
                    break;
                case "25":
                    index++;
                    background_back[index - 1] = "25";
                    BACKGOURNDCOLOR25 = new SolidColorBrush(Colors.Red);
                    break;
                case "26":
                    index++;
                    background_back[index - 1] = "26";
                    BACKGOURNDCOLOR26 = new SolidColorBrush(Colors.Black);
                    break;
                case "27":
                    index++;
                    background_back[index - 1] = "27";
                    BACKGOURNDCOLOR27 = new SolidColorBrush(Colors.Red);
                    break;
                case "28":
                    index++;
                    background_back[index - 1] = "28";
                    BACKGOURNDCOLOR28 = new SolidColorBrush(Colors.Black);
                    break;
                case "29":
                    index++;
                    background_back[index - 1] = "29";
                    BACKGOURNDCOLOR29 = new SolidColorBrush(Colors.Black);
                    break;
                case "30":
                    index++;
                    background_back[index - 1] = "30";
                    BACKGOURNDCOLOR30 = new SolidColorBrush(Colors.Red);
                    break;
                case "31":
                    index++;
                    background_back[index - 1] = "31";
                    BACKGOURNDCOLOR31 = new SolidColorBrush(Colors.Black);
                    break;
                case "32":
                    index++;
                    background_back[index - 1] = "32";
                    BACKGOURNDCOLOR32 = new SolidColorBrush(Colors.Red);
                    break;
                case "33":
                    index++;
                    background_back[index - 1] = "33";
                    BACKGOURNDCOLOR33 = new SolidColorBrush(Colors.Black);
                    break;
                case "34":
                    index++;
                    background_back[index - 1] = "34";
                    BACKGOURNDCOLOR34 = new SolidColorBrush(Colors.Red);
                    break;
                case "35":
                    index++;
                    background_back[index - 1] = "35";
                    BACKGOURNDCOLOR35 = new SolidColorBrush(Colors.Black);
                    break;
                case "36":
                    index++;
                    background_back[index - 1] = "36";
                    BACKGOURNDCOLOR36 = new SolidColorBrush(Colors.Red);
                    break;
            }
        }
        private void Event_btn(string parameter)
        {
            if (parameter == "Event_reset")
            {
                index = 0;
                BACKGOURNDCOLOR0 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR1 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR2 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR3 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR4 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR5 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR6 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR7 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR8 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR9 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR10 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR11 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR12 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR13 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR14 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR15 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR16 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR17 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR18 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR19 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR20 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR21 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR22 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR23 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR24 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR25 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR26 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR27 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR28 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR29 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR30 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR31 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR32 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR33 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR34 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR35 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR36 = new SolidColorBrush(Colors.DarkSlateGray);
            }
            if (parameter == "Event_back")
            {
                if (index > 0)
                {
                    index--;
                }
                BACKGOURNDCOLOR0 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR1 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR2 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR3 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR4 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR5 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR6 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR7 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR8 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR9 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR10 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR11 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR12 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR13 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR14 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR15 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR16 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR17 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR18 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR19 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR20 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR21 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR22 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR23 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR24 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR25 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR26 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR27 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR28 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR29 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR30 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR31 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR32 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR33 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR34 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR35 = new SolidColorBrush(Colors.DarkSlateGray);
                BACKGOURNDCOLOR36 = new SolidColorBrush(Colors.DarkSlateGray);

                for (int i = 0; i < index; i++)
                {
                    switch (background_back[i])
                    {
                        case "0":
                            BACKGOURNDCOLOR0 = new SolidColorBrush(Colors.DarkGreen);
                            break;
                        case "1":
                            BACKGOURNDCOLOR1 = new SolidColorBrush(Colors.Red);
                            break;
                        case "2":
                            BACKGOURNDCOLOR2 = new SolidColorBrush(Colors.Black);
                            break;
                        case "3":
                            BACKGOURNDCOLOR3 = new SolidColorBrush(Colors.Red);
                            break;
                        case "4":
                            BACKGOURNDCOLOR4 = new SolidColorBrush(Colors.Black);
                            break;
                        case "5":
                            BACKGOURNDCOLOR5 = new SolidColorBrush(Colors.Red);
                            break;
                        case "6":
                            BACKGOURNDCOLOR6 = new SolidColorBrush(Colors.Black);
                            break;
                        case "7":
                            BACKGOURNDCOLOR7 = new SolidColorBrush(Colors.Red);
                            break;
                        case "8":
                            BACKGOURNDCOLOR8 = new SolidColorBrush(Colors.Black);
                            break;
                        case "9":
                            BACKGOURNDCOLOR9 = new SolidColorBrush(Colors.Red);
                            break;
                        case "10":
                            BACKGOURNDCOLOR10 = new SolidColorBrush(Colors.Black);
                            break;
                        case "11":
                            BACKGOURNDCOLOR11 = new SolidColorBrush(Colors.Black);
                            break;
                        case "12":
                            BACKGOURNDCOLOR12 = new SolidColorBrush(Colors.Red);
                            break;
                        case "13":
                            BACKGOURNDCOLOR13 = new SolidColorBrush(Colors.Black);
                            break;
                        case "14":
                            BACKGOURNDCOLOR14 = new SolidColorBrush(Colors.Red);
                            break;
                        case "15":
                            BACKGOURNDCOLOR15 = new SolidColorBrush(Colors.Black);
                            break;
                        case "16":
                            BACKGOURNDCOLOR16 = new SolidColorBrush(Colors.Red);
                            break;
                        case "17":
                            BACKGOURNDCOLOR17 = new SolidColorBrush(Colors.Black);
                            break;
                        case "18":
                            BACKGOURNDCOLOR18 = new SolidColorBrush(Colors.Red);
                            break;
                        case "19":
                            BACKGOURNDCOLOR19 = new SolidColorBrush(Colors.Red);
                            break;
                        case "20":
                            BACKGOURNDCOLOR20 = new SolidColorBrush(Colors.Black);
                            break;
                        case "21":
                            BACKGOURNDCOLOR21 = new SolidColorBrush(Colors.Red);
                            break;
                        case "22":
                            BACKGOURNDCOLOR22 = new SolidColorBrush(Colors.Black);
                            break;
                        case "23":
                            BACKGOURNDCOLOR23 = new SolidColorBrush(Colors.Red);
                            break;
                        case "24":
                            BACKGOURNDCOLOR24 = new SolidColorBrush(Colors.Black);
                            break;
                        case "25":
                            BACKGOURNDCOLOR25 = new SolidColorBrush(Colors.Red);
                            break;
                        case "26":
                            BACKGOURNDCOLOR26 = new SolidColorBrush(Colors.Black);
                            break;
                        case "27":
                            BACKGOURNDCOLOR27 = new SolidColorBrush(Colors.Red);
                            break;
                        case "28":
                            BACKGOURNDCOLOR28 = new SolidColorBrush(Colors.Black);
                            break;
                        case "29":
                            BACKGOURNDCOLOR29 = new SolidColorBrush(Colors.Black);
                            break;
                        case "30":
                            BACKGOURNDCOLOR30 = new SolidColorBrush(Colors.Red);
                            break;
                        case "31":
                            BACKGOURNDCOLOR31 = new SolidColorBrush(Colors.Black);
                            break;
                        case "32":
                            BACKGOURNDCOLOR32 = new SolidColorBrush(Colors.Red);
                            break;
                        case "33":
                            BACKGOURNDCOLOR33 = new SolidColorBrush(Colors.Black);
                            break;
                        case "34":
                            BACKGOURNDCOLOR34 = new SolidColorBrush(Colors.Red);
                            break;
                        case "35":
                            BACKGOURNDCOLOR35 = new SolidColorBrush(Colors.Black);
                            break;
                        case "36":
                            BACKGOURNDCOLOR36 = new SolidColorBrush(Colors.Red);
                            break;
                    }
                }
            }
        }
    }
}