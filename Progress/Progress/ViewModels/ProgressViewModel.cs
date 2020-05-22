using Prism.Commands;
using Prism.Mvvm;
using System.ComponentModel;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Input;
using System;
using Prism.Events;
using RouletteSimulator.Core.EventAggregator;

namespace Progress.ViewModels
{
    /// <summary>
    /// Interaction logic for App.xaml
    /// </summary>
    public class ProgressViewModel : BindableBase
    {
        private double _percent_red;
        private double _percent_black;
        private double _percent_odd;
        private double _percent_even;

        private string _percent_red_num = "";
        private string _percent_black_num = "";
        private string _percent_odd_num = "";
        private string _percent_even_num = "";

        double percent_R;
        double percent_B;
        double percent_O;
        double percent_E;

        double count_red;
        double count_black;
        double count_odd;
        double count_even;

        int index;
        string[] back_percent = new string[1000];

        public double percent_red
        {
            get { return _percent_red; }
            set
            {
                SetProperty(ref _percent_red, value);
            }
        }
        public double percent_black
        {
            get { return _percent_black; }
            set
            {
                SetProperty(ref _percent_black, value);
            }
        }
        public string percent_red_num
        {
            get { return _percent_red_num; }
            set
            {
                SetProperty(ref _percent_red_num, value);
            }
        }
        public string percent_black_num
        {
            get { return _percent_black_num; }
            set
            {
                SetProperty(ref _percent_black_num, value);
            }
        }
        public double percent_odd
        {
            get { return _percent_odd; }
            set
            {
                SetProperty(ref _percent_odd, value);
            }
        }
        public double percent_even
        {
            get { return _percent_even; }
            set
            {
                SetProperty(ref _percent_even, value);
            }
        }
        public string percent_odd_num
        {
            get { return _percent_odd_num; }
            set
            {
                SetProperty(ref _percent_odd_num, value);
            }
        }
        public string percent_even_num
        {
            get { return _percent_even_num; }
            set
            {
                SetProperty(ref _percent_even_num, value);
            }
        }

        public ProgressViewModel(IEventAggregator ea)
        {
            ea.GetEvent<Keyboard_Num>().Subscribe(Number);
            ea.GetEvent<Button_Event>().Subscribe(Btn_Event);
        }

        private void Number(string parameter)
        {
            if (parameter == "spe_even")
            {
                count_even += 18;
            }
            else if (parameter == "spe_odd")
            {
                count_odd += 18;
            }
            else if (parameter == "spe_red")
            {
                count_red += 18;
            }
            else if (parameter == "spe_black")
            {
                count_black += 18;
            }
            else
            {
                switch (Int32.Parse(parameter))
                {
                    case 1:
                        index++;
                        back_percent[index - 1] = "1";
                        ++count_red;
                        ++count_odd;
                        break;
                    case 3:
                        index++;
                        back_percent[index - 1] = "3";
                        ++count_red;
                        ++count_odd;
                        break;
                    case 5:
                        index++;
                        back_percent[index - 1] = "5";
                        ++count_red;
                        ++count_odd;
                        break;
                    case 7:
                        index++;
                        back_percent[index - 1] = "7";
                        ++count_red;
                        ++count_odd;
                        break;
                    case 9:
                        index++;
                        back_percent[index - 1] = "9";
                        ++count_red;
                        ++count_odd;
                        break;
                    case 12:
                        index++;
                        back_percent[index - 1] = "12";
                        ++count_red;
                        ++count_even;
                        break;
                    case 14:
                        index++;
                        back_percent[index - 1] = "14";
                        ++count_red;
                        ++count_even;
                        break;
                    case 16:
                        index++;
                        back_percent[index - 1] = "16";
                        ++count_red;
                        ++count_even;
                        break;
                    case 18:
                        index++;
                        back_percent[index - 1] = "18";
                        ++count_red;
                        ++count_even;
                        break;
                    case 19:
                        index++;
                        back_percent[index - 1] = "19";
                        ++count_red;
                        ++count_odd;
                        break;
                    case 21:
                        index++;
                        back_percent[index - 1] = "21";
                        ++count_red;
                        ++count_odd;
                        break;
                    case 23:
                        index++;
                        back_percent[index - 1] = "23";
                        ++count_red;
                        ++count_odd;
                        break;
                    case 25:
                        index++;
                        back_percent[index - 1] = "25";
                        ++count_red;
                        ++count_odd;
                        break;
                    case 27:
                        index++;
                        back_percent[index - 1] = "27";
                        ++count_red;
                        ++count_odd;
                        break;
                    case 32:
                        index++;
                        back_percent[index - 1] = "32";
                        ++count_red;
                        ++count_even;
                        break;
                    case 34:
                        index++;
                        back_percent[index - 1] = "34";
                        ++count_red;
                        ++count_even;
                        break;
                    case 36:
                        index++;
                        back_percent[index - 1] = "36";
                        ++count_red;
                        ++count_even;
                        break;

                    //black

                    case 2:
                        index++;
                        back_percent[index - 1] = "2";
                        ++count_black;
                        ++count_even;
                        break;
                    case 4:
                        index++;
                        back_percent[index - 1] = "4";
                        ++count_black;
                        ++count_even;
                        break;
                    case 6:
                        index++;
                        back_percent[index - 1] = "6";
                        ++count_black;
                        ++count_even;
                        break;
                    case 8:
                        index++;
                        back_percent[index - 1] = "8";
                        ++count_black;
                        ++count_even;
                        break;
                    case 10:
                        index++;
                        back_percent[index - 1] = "10";
                        ++count_black;
                        ++count_even;
                        break;
                    case 11:
                        index++;
                        back_percent[index - 1] = "11";
                        ++count_black;
                        ++count_odd;
                        break;
                    case 13:
                        index++;
                        back_percent[index - 1] = "13";
                        ++count_black;
                        ++count_odd;
                        break;
                    case 15:
                        index++;
                        back_percent[index - 1] = "15";
                        ++count_black;
                        ++count_odd;
                        break;
                    case 17:
                        index++;
                        back_percent[index - 1] = "17";
                        ++count_black;
                        ++count_odd;
                        break;
                    case 20:
                        index++;
                        back_percent[index - 1] = "20";
                        ++count_black;
                        ++count_even;
                        break;
                    case 24:
                        index++;
                        back_percent[index - 1] = "24";
                        ++count_black;
                        ++count_even;
                        break;
                    case 22:
                        index++;
                        back_percent[index - 1] = "22";
                        ++count_black;
                        ++count_even;
                        break;
                    case 26:
                        index++;
                        back_percent[index - 1] = "26";
                        ++count_black;
                        ++count_even;
                        break;
                    case 29:
                        index++;
                        back_percent[index - 1] = "29";
                        ++count_black;
                        ++count_odd;
                        break;
                    case 28:
                        index++;
                        back_percent[index - 1] = "28";
                        ++count_black;
                        ++count_even;
                        break;
                    case 31:
                        index++;
                        back_percent[index - 1] = "31";
                        ++count_black;
                        ++count_odd;
                        break;
                    case 33:
                        index++;
                        back_percent[index - 1] = "33";
                        ++count_black;
                        ++count_odd;
                        break;
                    case 35:
                        index++;
                        back_percent[index - 1] = "35";
                        ++count_black;
                        ++count_odd;
                        break;
                }
            }

            percent_R = count_red / (count_red + count_black) * 100;
            percent_B = count_black / (count_black + count_red) * 100;

            percent_O = count_odd / (count_odd + count_even) * 100;
            percent_E = count_even / (count_even + count_odd) * 100;

            percent_red = percent_R;
            percent_black = percent_B;
            percent_even = percent_E;
            percent_odd = percent_O;

            percent_red_num = Math.Truncate(percent_R).ToString() + " % ";
            percent_black_num = Math.Truncate(percent_B).ToString() + " % ";
            percent_even_num = Math.Truncate(percent_E).ToString() + " % ";
            percent_odd_num = Math.Truncate(percent_O).ToString() + " % ";
        }
        private void Btn_Event(string parameter)
        {
            if (parameter == "Event_reset")
            {
                index = 0;
                count_black = 0;
                count_even = 0;
                count_odd = 0;
                count_red = 0;

                percent_R = 0;
                percent_B = 0;

                percent_O = 0;
                percent_E = 0;

                percent_red = 0;
                percent_black = 0;
                percent_even = 0;
                percent_odd = 0;

                percent_red_num = "  ";
                percent_black_num = "  ";
                percent_even_num = "  ";
                percent_odd_num = "  ";
            }
            if (parameter == "Event_back")
            {
                if (index > 0)
                {
                    index--;
                }

                count_black = 0;
                count_even = 0;
                count_odd = 0;
                count_red = 0;

                percent_R = 0;
                percent_B = 0;

                percent_O = 0;
                percent_E = 0;

                percent_red = 0;
                percent_black = 0;
                percent_even = 0;
                percent_odd = 0;

                percent_red_num = "  ";
                percent_black_num = "  ";
                percent_even_num = "  ";
                percent_odd_num = "  ";

                for (int i = 0; i < index; i++)
                {
                    switch (back_percent[i])
                    {
                        case "1":
                            ++count_red;
                            ++count_odd;
                            break;
                        case "3":
                            ++count_red;
                            ++count_odd;
                            break;
                        case "5":
                            ++count_red;
                            ++count_odd;
                            break;
                        case "7":
                            ++count_red;
                            ++count_odd;
                            break;
                        case "9":
                            ++count_red;
                            ++count_odd;
                            break;
                        case "12":
                            ++count_red;
                            ++count_even;
                            break;
                        case "14":
                            ++count_red;
                            ++count_even;
                            break;
                        case "16":
                            ++count_red;
                            ++count_even;
                            break;
                        case "18":
                            ++count_red;
                            ++count_even;
                            break;
                        case "19":
                            ++count_red;
                            ++count_odd;
                            break;
                        case "21":
                            ++count_red;
                            ++count_odd;
                            break;
                        case "23":
                            ++count_red;
                            ++count_odd;
                            break;
                        case "25":
                            ++count_red;
                            ++count_odd;
                            break;
                        case "27":
                            ++count_red;
                            ++count_odd;
                            break;
                        case "32":
                            ++count_red;
                            ++count_even;
                            break;
                        case "34":
                            ++count_red;
                            ++count_even;
                            break;
                        case "36":
                            ++count_red;
                            ++count_even;
                            break;

                        //black

                        case "2":
                            ++count_black;
                            ++count_even;
                            break;
                        case "4":
                            ++count_black;
                            ++count_even;
                            break;
                        case "6":
                            ++count_black;
                            ++count_even;
                            break;
                        case "8":
                            ++count_black;
                            ++count_even;
                            break;
                        case "10":
                            ++count_black;
                            ++count_even;
                            break;
                        case "11":
                            ++count_black;
                            ++count_odd;
                            break;
                        case "13":
                            ++count_black;
                            ++count_odd;
                            break;
                        case "15":
                            ++count_black;
                            ++count_odd;
                            break;
                        case "17":
                            ++count_black;
                            ++count_odd;
                            break;
                        case "20":
                            ++count_black;
                            ++count_even;
                            break;
                        case "24":
                            ++count_black;
                            ++count_even;
                            break;
                        case "22":
                            ++count_black;
                            ++count_even;
                            break;
                        case "26":
                            ++count_black;
                            ++count_even;
                            break;
                        case "29":
                            ++count_black;
                            ++count_odd;
                            break;
                        case "28":
                            ++count_black;
                            ++count_even;
                            break;
                        case "31":
                            ++count_black;
                            ++count_odd;
                            break;
                        case "33":
                            ++count_black;
                            ++count_odd;
                            break;
                        case "35":
                            ++count_black;
                            ++count_odd;
                            break;
                    }
                }
                if ((count_red == 0) && count_black == 0 && count_odd == 0 && count_even == 0)
                {
                    percent_red = 0;
                    percent_black = 0;
                    percent_even = 0;
                    percent_odd = 0;

                    percent_red_num = (0).ToString() + " % ";
                    percent_black_num = (0).ToString() + " % ";
                    percent_even_num = (0).ToString() + " % ";
                    percent_odd_num = (0).ToString() + " % ";
                }
                else
                {

                    percent_R = count_red / (count_red + count_black) * 100;
                    percent_B = count_black / (count_black + count_red) * 100;

                    percent_O = count_odd / (count_odd + count_even) * 100;
                    percent_E = count_even / (count_even + count_odd) * 100;

                    percent_red = percent_R;
                    percent_black = percent_B;
                    percent_even = percent_E;
                    percent_odd = percent_O;

                    percent_red_num = Math.Truncate(percent_R).ToString() + " % ";
                    percent_black_num = Math.Truncate(percent_B).ToString() + " % ";
                    percent_even_num = Math.Truncate(percent_E).ToString() + " % ";
                    percent_odd_num = Math.Truncate(percent_O).ToString() + " % ";
                }
            }
        }
    }

}
