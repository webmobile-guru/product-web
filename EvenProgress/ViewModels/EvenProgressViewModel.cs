using Prism.Commands;
using Prism.Mvvm;
using System.ComponentModel;
using System.Threading;
using System.Threading.Tasks;
using System.Windows.Input;
using System;
using Prism.Events;
using RouletteSimulator.Core.EventAggregator;

namespace EvenProgress.ViewModels
{
    public class EvenProgressViewModel : BindableBase
    {
        private double _percent_zone1;
        private double _percent_zone2;
        private double _percent_zone3;
        private double _percent_zone4;

        private string _percent_zone1_num = "";
        private string _percent_zone2_num = "";
        private string _percent_zone3_num = "";
        private string _percent_zone4_num = "";

        double percent_1;
        double percent_2;
        double percent_3;
        double percent_4;

        int index;
        string[] back_percent = new string[1000];

        double count_1;
        double count_2;
        double count_3;
        double count_4;

        public double percent_zone1
        {
            get { return _percent_zone1; }
            set
            {
                SetProperty(ref _percent_zone1, value);
            }
        }
        public double percent_zone2
        {
            get { return _percent_zone2; }
            set
            {
                SetProperty(ref _percent_zone2, value);
            }
        }
        public double percent_zone3
        {
            get { return _percent_zone3; }
            set
            {
                SetProperty(ref _percent_zone3, value);
            }
        }
        public double percent_zone4
        {
            get { return _percent_zone4; }
            set
            {
                SetProperty(ref _percent_zone4, value);
            }
        }

        public string percent_zone1_num
        {
            get { return _percent_zone1_num; }
            set
            {
                SetProperty(ref _percent_zone1_num, value);
            }
        }
        public string percent_zone2_num
        {
            get { return _percent_zone2_num; }
            set
            {
                SetProperty(ref _percent_zone2_num, value);
            }
        }

        public string percent_zone3_num
        {
            get { return _percent_zone3_num; }
            set
            {
                SetProperty(ref _percent_zone3_num, value);
            }
        }
        public string percent_zone4_num
        {
            get { return _percent_zone4_num; }
            set
            {
                SetProperty(ref _percent_zone4_num, value);
            }
        }

        public EvenProgressViewModel(IEventAggregator ea)
        {
            ea.GetEvent<Keyboard_Num>().Subscribe(Number);
            ea.GetEvent<Button_Event>().Subscribe(Btn_Event);
        }

        private void Number(string parameter)
        {
            if (parameter == "spe_even")
            {
                count_1 += 5;
                count_2 += 4;
                count_3 += 5;
                count_4 += 4;
            }
            else if (parameter == "spe_odd")
            {
                count_1 += 4;
                count_2 += 5;
                count_3 += 4;
                count_4 += 5;
            }
            else if (parameter == "spe_red")
            {
                count_1 += 4;
                count_2 += 5;
                count_3 += 4;
                count_4 += 5;
            }
            else if (parameter == "spe_black")
            {
                count_1 += 5;
                count_2 += 4;
                count_3 += 5;
                count_4 += 4;
            }
            else
            {
                if (Int32.Parse(parameter) == 26 || Int32.Parse(parameter) == 3 || Int32.Parse(parameter) == 35 || Int32.Parse(parameter) == 12 || Int32.Parse(parameter) == 28 || Int32.Parse(parameter) == 7 || Int32.Parse(parameter) == 29 || Int32.Parse(parameter) == 18 || Int32.Parse(parameter) == 22)
                {
                    ++count_1;
                    index++;
                    back_percent[index - 1] = "1";
                }

                if (Int32.Parse(parameter) == 32 || Int32.Parse(parameter) == 15 || Int32.Parse(parameter) == 19 || Int32.Parse(parameter) == 4 || Int32.Parse(parameter) == 21 || Int32.Parse(parameter) == 2 || Int32.Parse(parameter) == 25 || Int32.Parse(parameter) == 17 || Int32.Parse(parameter) == 34)
                {
                    ++count_2; index++;
                    back_percent[index - 1] = "2";
                }

                if (Int32.Parse(parameter) == 6 || Int32.Parse(parameter) == 27 || Int32.Parse(parameter) == 13 || Int32.Parse(parameter) == 36 || Int32.Parse(parameter) == 11 || Int32.Parse(parameter) == 30 || Int32.Parse(parameter) == 8 || Int32.Parse(parameter) == 23 || Int32.Parse(parameter) == 10)
                {
                    ++count_3; index++;
                    back_percent[index - 1] = "3";
                }

                if (Int32.Parse(parameter) == 5 || Int32.Parse(parameter) == 24 || Int32.Parse(parameter) == 16 || Int32.Parse(parameter) == 33 || Int32.Parse(parameter) == 1 || Int32.Parse(parameter) == 20 || Int32.Parse(parameter) == 14 || Int32.Parse(parameter) == 31 || Int32.Parse(parameter) == 9)
                {
                    ++count_4; index++;
                    back_percent[index - 1] = "4";
                }
            }



            percent_1 = count_1 / (count_1 + count_2 + count_3 + count_4) * 100;
            percent_2 = count_2 / (count_1 + count_2 + count_3 + count_4) * 100;
            percent_3 = count_3 / (count_1 + count_2 + count_3 + count_4) * 100;
            percent_4 = count_4 / (count_1 + count_2 + count_3 + count_4) * 100;

            percent_zone1 = percent_1;
            percent_zone2 = percent_2;
            percent_zone3 = percent_3;
            percent_zone4 = percent_4;

            percent_zone1_num = Math.Truncate(percent_1).ToString() + " % ";
            percent_zone2_num = Math.Truncate(percent_2).ToString() + " % ";
            percent_zone3_num = Math.Truncate(percent_3).ToString() + " % ";
            percent_zone4_num = Math.Truncate(percent_4).ToString() + " % ";
        }
        private void Btn_Event(string parameter)
        {
            if (parameter == "Event_reset")
            {
                index = 0;
                count_1 = 0;
                count_2 = 0;
                count_2 = 0;
                count_4 = 0;

                percent_1 = 0;
                percent_2 = 0;
                percent_3 = 0;
                percent_4 = 0;

                percent_zone1 = 0;
                percent_zone2 = 0;
                percent_zone3 = 0;
                percent_zone4 = 0;

                percent_zone1_num = "  ";
                percent_zone2_num = "  ";
                percent_zone3_num = "  ";
                percent_zone4_num = "  ";
            }
            if (parameter == "Event_back")
            {
                count_1 = 0;
                count_2 = 0;
                count_3 = 0;
                count_4 = 0;

                percent_1 = 0;
                percent_2 = 0;
                percent_3 = 0;
                percent_4 = 0;

                percent_zone1 = 0;
                percent_zone2 = 0;
                percent_zone3 = 0;
                percent_zone4 = 0;

                percent_zone1_num = "  ";
                percent_zone2_num = "  ";
                percent_zone3_num = "  ";
                percent_zone4_num = "  ";

                if (index > 0)
                {
                    index--;
                }

                for (int i = 0; i < index; i++)
                {
                    switch (back_percent[i])
                    {
                        case "1":
                            ++count_1;
                            break;
                        case "2":
                            ++count_2;
                            break;
                        case "3":
                            ++count_3;
                            break;
                        case "4":
                            ++count_4;
                            break;
                    }
                }

                if (count_1 == 0 && count_2 == 0 && count_3 == 0 && count_4 == 0)
                {
                    percent_zone1 = 0;
                    percent_zone2 = 0;
                    percent_zone3 = 0;
                    percent_zone4 = 0;

                    percent_zone1_num = 0.ToString() + " % ";
                    percent_zone2_num = 0.ToString() + " % ";
                    percent_zone3_num = 0.ToString() + " % ";
                    percent_zone4_num = 0.ToString() + " % ";
                }
                else
                {
                    percent_1 = count_1 / (count_1 + count_2 + count_3 + count_4) * 100;
                    percent_2 = count_2 / (count_1 + count_2 + count_3 + count_4) * 100;
                    percent_3 = count_3 / (count_1 + count_2 + count_3 + count_4) * 100;
                    percent_4 = count_4 / (count_1 + count_2 + count_3 + count_4) * 100;

                    percent_zone1 = percent_1;
                    percent_zone2 = percent_2;
                    percent_zone3 = percent_3;
                    percent_zone4 = percent_4;

                    percent_zone1_num = Math.Truncate(percent_1).ToString() + " % ";
                    percent_zone2_num = Math.Truncate(percent_2).ToString() + " % ";
                    percent_zone3_num = Math.Truncate(percent_3).ToString() + " % ";
                    percent_zone4_num = Math.Truncate(percent_4).ToString() + " % ";
                }
            }
        }
    }

}

