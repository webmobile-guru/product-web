using Prism.Events;
using Prism.Mvvm;
using RouletteSimulator.Core.EventAggregator;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;

namespace PrediectText.ViewModels
{
    public class PredictTextViewModel : BindableBase
    {
        private ObservableCollection<string> _messages = new ObservableCollection<string>();
        private ObservableCollection<string> _predict_num = new ObservableCollection<string>();
        private ObservableCollection<string> _PART_S = new ObservableCollection<string>();
        private ObservableCollection<string> _ROW_S = new ObservableCollection<string>();
        private ObservableCollection<string> _DOZEN_S = new ObservableCollection<string>();
        private ObservableCollection<string> _ODDEVEN_S = new ObservableCollection<string>();
        readonly int[] predictor_arr = new int[100];
        int available_num;
        //string predict_string;

        double[] top_part_index = new double[4];
        string top_part = "part_0";
        string top_number = "0";
        string top_number_1 = "0";
        int No_result;
        //for predict part -- member frequency
        int[] Part1_Member = new int[9];
        int[] Part2_Member = new int[9];
        int[] Part3_Member = new int[9];
        int[] Part4_Member = new int[9];

        string lastest;

        //for back  result value
        string[] back_resultValue = new string[1000];
        //for back part symbol
        int No_partsymbol;
        string[] back_partsymbol = new string[1000];
        //for back row symbol
        int No_rowsymbol;
        string[] back_rowsymbol = new string[1000];
        //back dozen symbol
        int No_dozensymbol;
        string[] back_dozensymbol = new string[1000];
        //odd even symbol
        int No_oddevensymbol;
        string[] back_oddevensymbol = new string[1000];

        int[] count_part0_num = new int[1];
        int[] count_part1_num = new int[9];
        int[] count_part2_num = new int[9];
        int[] count_part3_num = new int[9];
        int[] count_part4_num = new int[9];

        string[] part_symbols = new string[10];

        public ObservableCollection<string> Predict_num
        {
            get { return _predict_num; }
            set { SetProperty(ref _predict_num, value); }
        }
        public ObservableCollection<string> PART_S
        {
            get { return _PART_S; }
            set { SetProperty(ref _PART_S, value); }
        }
        public ObservableCollection<string> ROW_S
        {
            get { return _ROW_S; }
            set { SetProperty(ref _ROW_S, value); }
        }
        public ObservableCollection<string> DOZEN_S
        {
            get { return _DOZEN_S; }
            set { SetProperty(ref _DOZEN_S, value); }
        }
        public ObservableCollection<string> ODDEVEN_S
        {
            get { return _ODDEVEN_S; }
            set { SetProperty(ref _ODDEVEN_S, value); }
        }


        public ObservableCollection<string> Messages
        {
            get { return _messages; }
            set { SetProperty(ref _messages, value); }
        }

        private ObservableCollection<string> _number = new ObservableCollection<string>();

        public ObservableCollection<string> Number
        {
            get { return _number; }
            set { SetProperty(ref _number, value); }
        }

        public int Available_num { get => available_num; set => available_num = value; }

        public PredictTextViewModel(IEventAggregator ea)
        {
            ea.GetEvent<MessageSentEvent>().Subscribe(MessageReceived);
            ea.GetEvent<Keyboard_Num>().Subscribe(Number_show);
            ea.GetEvent<Keyboard_Num>().Subscribe(Predict);
            ea.GetEvent<Keyboard_Num>().Subscribe(Part_symbol);
            ea.GetEvent<Keyboard_Num>().Subscribe(Row_symbol);
            ea.GetEvent<Keyboard_Num>().Subscribe(Dozen_symbol);
            ea.GetEvent<Keyboard_Num>().Subscribe(Oddeven_symbol);
            ea.GetEvent<Button_Event>().Subscribe(Event_btn);
        }

        private void Predict(String parameter)
        {

            if (parameter == "spe_even")
            {
                top_part_index[0] += 5;
                top_part_index[1] += 4;
                top_part_index[2] += 5;
                top_part_index[3] += 4;
                count_part1_num[0]++;
                count_part1_num[3]++;
                count_part1_num[7]++;
                count_part1_num[8]++;
                count_part2_num[0]++;
                count_part2_num[3]++;
                count_part2_num[5]++;
                count_part2_num[8]++;
                count_part3_num[0]++;
                count_part3_num[2]++;
                count_part3_num[3]++;
                count_part3_num[5]++;
                count_part3_num[8]++;
                count_part4_num[2]++;
                count_part4_num[3]++;
                count_part4_num[6]++;
                count_part4_num[7]++;
            }
            else if (parameter == "spe_odd")
            {
                top_part_index[0] += 4;
                top_part_index[1] += 5;
                top_part_index[2] += 4;
                top_part_index[3] += 5;
                count_part1_num[1]++;
                count_part1_num[2]++;
                count_part1_num[5]++;
                count_part1_num[6]++;
                count_part2_num[1]++;
                count_part2_num[2]++;
                count_part2_num[4]++;
                count_part2_num[6]++;
                count_part2_num[7]++;
                count_part3_num[1]++;
                count_part3_num[4]++;
                count_part3_num[6]++;
                count_part3_num[7]++;
                count_part4_num[0]++;
                count_part4_num[1]++;
                count_part4_num[4]++;
                count_part4_num[5]++;
                count_part4_num[8]++;
            }
            else if (parameter == "spe_red")
            {
                top_part_index[0] += 4;
                top_part_index[1] += 5;
                top_part_index[2] += 4;
                top_part_index[3] += 5;
                count_part1_num[1]++;
                count_part1_num[3]++;
                count_part1_num[5]++;
                count_part1_num[7]++;
                count_part2_num[0]++;
                count_part2_num[2]++;
                count_part2_num[4]++;
                count_part2_num[6]++;
                count_part2_num[8]++;
                count_part3_num[1]++;
                count_part3_num[3]++;
                count_part3_num[5]++;
                count_part3_num[7]++;
                count_part4_num[0]++;
                count_part4_num[2]++;
                count_part4_num[4]++;
                count_part4_num[6]++;
                count_part4_num[8]++;
            }
            else if (parameter == "spe_black")
            {
                top_part_index[0] += 5;
                top_part_index[1] += 4;
                top_part_index[2] += 5;
                top_part_index[3] += 4;
                count_part1_num[0]++;
                count_part1_num[2]++;
                count_part1_num[4]++;
                count_part1_num[6]++;
                count_part1_num[8]++;
                count_part2_num[1]++;
                count_part2_num[3]++;
                count_part2_num[5]++;
                count_part2_num[7]++;
                count_part3_num[0]++;
                count_part3_num[2]++;
                count_part3_num[4]++;
                count_part3_num[6]++;
                count_part3_num[8]++;
                count_part4_num[1]++;
                count_part4_num[3]++;
                count_part4_num[5]++;
                count_part4_num[7]++;
            }
            else
            {
                if (Int32.Parse(parameter) == 26 || Int32.Parse(parameter) == 3 || Int32.Parse(parameter) == 35 || Int32.Parse(parameter) == 12 || Int32.Parse(parameter) == 28 || Int32.Parse(parameter) == 7 || Int32.Parse(parameter) == 29 || Int32.Parse(parameter) == 18 || Int32.Parse(parameter) == 22)
                {
                    lastest = "1";
                    int part_value = 0;
                    if (Int32.Parse(parameter) == 26)
                    {
                        Part1_Member[0] = 1;

                    }

                    if (Int32.Parse(parameter) == 3)
                    {
                        Part1_Member[1] = 1;
                    }

                    if (Int32.Parse(parameter) == 35)
                    {
                        Part1_Member[2] = 1;
                    }

                    if (Int32.Parse(parameter) == 12)
                    {
                        Part1_Member[3] = 1;
                    }

                    if (Int32.Parse(parameter) == 28)
                    {
                        Part1_Member[4] = 1;
                    }

                    if (Int32.Parse(parameter) == 7)
                    {
                        Part1_Member[5] = 1;
                    }

                    if (Int32.Parse(parameter) == 29)
                    {
                        Part1_Member[6] = 1;
                    }

                    if (Int32.Parse(parameter) == 18)
                    {
                        Part1_Member[7] = 1;
                    }

                    if (Int32.Parse(parameter) == 22)
                    {
                        Part1_Member[8] = 1;
                    }


                    for (int i = 0; i < 9; i++)
                    {
                        part_value += Part1_Member[i];
                    }

                    top_part_index[0] = part_value; ;
                    int tmp = part_value;
                }
                else if (Int32.Parse(parameter) == 32 || Int32.Parse(parameter) == 15 || Int32.Parse(parameter) == 19 || Int32.Parse(parameter) == 4 || Int32.Parse(parameter) == 21 || Int32.Parse(parameter) == 2 || Int32.Parse(parameter) == 25 || Int32.Parse(parameter) == 17 || Int32.Parse(parameter) == 34)
                {
                    lastest = "2";
                    int part_value = 0;
                    if (Int32.Parse(parameter) == 32)
                    {
                        Part2_Member[0] = 1;
                    }

                    if (Int32.Parse(parameter) == 15)
                    {
                        Part2_Member[1] = 1;
                    }

                    if (Int32.Parse(parameter) == 19)
                    {
                        Part2_Member[2] = 1;
                    }

                    if (Int32.Parse(parameter) == 4)
                    {
                        Part2_Member[3] = 1;
                    }

                    if (Int32.Parse(parameter) == 21)
                    {
                        Part2_Member[4] = 1;
                    }

                    if (Int32.Parse(parameter) == 2)
                    {
                        Part2_Member[5] = 1;
                    }

                    if (Int32.Parse(parameter) == 25)
                    {
                        Part2_Member[6] = 1;
                    }

                    if (Int32.Parse(parameter) == 17)
                    {
                        Part2_Member[7] = 1;
                    }

                    if (Int32.Parse(parameter) == 34)
                    {
                        Part2_Member[8] = 1;
                    }


                    for (int i = 0; i < 9; i++)
                    {
                        part_value += Part2_Member[i];
                    }

                    top_part_index[1] = part_value; ;
                    int tmp = part_value;
                }
                else if (Int32.Parse(parameter) == 6 || Int32.Parse(parameter) == 27 || Int32.Parse(parameter) == 13 || Int32.Parse(parameter) == 36 || Int32.Parse(parameter) == 11 || Int32.Parse(parameter) == 30 || Int32.Parse(parameter) == 8 || Int32.Parse(parameter) == 23 || Int32.Parse(parameter) == 10)
                {
                    lastest = "3";
                    int part_value = 0;
                    if (Int32.Parse(parameter) == 6)
                    {
                        Part3_Member[0] = 1;
                    }

                    if (Int32.Parse(parameter) == 27)
                    {
                        Part3_Member[1] = 1;
                    }

                    if (Int32.Parse(parameter) == 13)
                    {
                        Part3_Member[2] = 1;
                    }

                    if (Int32.Parse(parameter) == 36)
                    {
                        Part3_Member[3] = 1;
                    }

                    if (Int32.Parse(parameter) == 11)
                    {
                        Part3_Member[4] = 1;
                    }

                    if (Int32.Parse(parameter) == 30)
                    {
                        Part3_Member[5] = 1;
                    }

                    if (Int32.Parse(parameter) == 8)
                    {
                        Part3_Member[6] = 1;
                    }

                    if (Int32.Parse(parameter) == 23)
                    {
                        Part3_Member[7] = 1;
                    }

                    if (Int32.Parse(parameter) == 10)
                    {
                        Part3_Member[8] = 1;
                    }


                    for (int i = 0; i < 9; i++)
                    {
                        part_value += Part3_Member[i];
                    }

                    top_part_index[2] = part_value; ;
                    int tmp = part_value;
                }
                else if (Int32.Parse(parameter) == 5 || Int32.Parse(parameter) == 24 || Int32.Parse(parameter) == 16 || Int32.Parse(parameter) == 33 || Int32.Parse(parameter) == 1 || Int32.Parse(parameter) == 20 || Int32.Parse(parameter) == 14 || Int32.Parse(parameter) == 31 || Int32.Parse(parameter) == 9)
                {
                    lastest = "4";
                    int part_value = 0;
                    if (Int32.Parse(parameter) == 5)
                    {
                        Part4_Member[0] = 1;
                    }

                    if (Int32.Parse(parameter) == 24)
                    {
                        Part4_Member[1] = 1;
                    }

                    if (Int32.Parse(parameter) == 16)
                    {
                        Part4_Member[2] = 1;
                    }

                    if (Int32.Parse(parameter) == 33)
                    {
                        Part4_Member[3] = 1;
                    }

                    if (Int32.Parse(parameter) == 1)
                    {
                        Part4_Member[4] = 1;
                    }

                    if (Int32.Parse(parameter) == 20)
                    {
                        Part4_Member[5] = 1;
                    }

                    if (Int32.Parse(parameter) == 14)
                    {
                        Part4_Member[6] = 1;
                    }

                    if (Int32.Parse(parameter) == 31)
                    {
                        Part4_Member[7] = 1;
                    }

                    if (Int32.Parse(parameter) == 9)
                    {
                        Part4_Member[8] = 1;
                    }


                    for (int i = 0; i < 9; i++)
                    {
                        part_value += Part4_Member[i];
                    }

                    top_part_index[3] = part_value; ;
                    int tmp = part_value;
                }

                switch (Int32.Parse(parameter))
                {
                    case 0:
                        count_part0_num[0]++;
                        ++Available_num;
                        break;
                    //this for part_1  -- 26,3,35,12,28,7,29,18,22
                    case 26:
                        count_part1_num[0]++;
                        ++Available_num;
                        break;
                    case 3:
                        count_part1_num[1]++;
                        ++Available_num;
                        break;
                    case 35:
                        count_part1_num[2]++;
                        ++Available_num;
                        break;
                    case 12:
                        count_part1_num[3]++;
                        ++Available_num;
                        break;
                    case 28:
                        count_part1_num[4]++;
                        ++Available_num;
                        break;
                    case 7:
                        count_part1_num[5]++;
                        ++Available_num;
                        break;
                    case 29:
                        count_part1_num[6]++;
                        ++Available_num;
                        break;
                    case 18:
                        count_part1_num[7]++;
                        ++Available_num;
                        break;
                    case 22:
                        count_part1_num[8]++;
                        ++Available_num;
                        break;

                    //this for part_2 -- 32 15 19 4 21 2 25 17 34
                    case 32:
                        count_part2_num[0]++;
                        ++Available_num;
                        break;
                    case 15:
                        count_part2_num[1]++;
                        ++Available_num;
                        break;
                    case 19:
                        count_part2_num[2]++;
                        ++Available_num;
                        break;
                    case 4:
                        count_part2_num[3]++;
                        ++Available_num;
                        break;
                    case 21:
                        count_part2_num[4]++;
                        ++Available_num;
                        break;
                    case 2:
                        count_part2_num[5]++;
                        ++Available_num;
                        break;
                    case 25:
                        count_part2_num[6]++;
                        ++Available_num;
                        break;
                    case 17:
                        count_part2_num[7]++;
                        ++Available_num;
                        break;
                    case 34:
                        count_part2_num[8]++;
                        ++Available_num;
                        break;
                    //this f0r part3 10 23 8 30 11 36 13 27 6
                    case 10:
                        count_part3_num[0]++;
                        ++Available_num;
                        break;
                    case 23:
                        count_part3_num[1]++;
                        ++Available_num;
                        break;
                    case 8:
                        count_part3_num[2]++;
                        ++Available_num;
                        break;
                    case 30:
                        count_part3_num[3]++;
                        ++Available_num;
                        break;
                    case 11:
                        count_part3_num[4]++;
                        ++Available_num;
                        break;
                    case 36:
                        count_part3_num[5]++;
                        ++Available_num;
                        break;
                    case 13:
                        count_part3_num[6]++;
                        ++Available_num;
                        break;
                    case 27:
                        count_part3_num[7]++;
                        ++Available_num;
                        break;
                    case 6:
                        count_part3_num[8]++;
                        ++Available_num;
                        break;

                    //this for part4 9 31 14 20 1 33 16 24 5
                    case 9:
                        count_part4_num[0]++;
                        ++Available_num;
                        break;
                    case 31:
                        count_part4_num[1]++;
                        ++Available_num;
                        break;
                    case 14:
                        count_part4_num[2]++;
                        ++Available_num;
                        break;
                    case 20:
                        ++Available_num;
                        count_part4_num[3]++;
                        break;
                    case 1:
                        count_part4_num[4]++;
                        ++Available_num;
                        break;
                    case 33:
                        count_part4_num[5]++;
                        ++Available_num;
                        break;
                    case 16:
                        count_part4_num[6]++;
                        ++Available_num;
                        break;
                    case 24:
                        count_part4_num[7]++;
                        ++Available_num;
                        break;
                    case 5:
                        count_part4_num[8]++;
                        ++Available_num;
                        break;
                }
            }

            //if(available_num >= 8 && available_btn)
            {
                // double p1 = top_part_index[0];
                //double p2 = top_part_index[1];
                // double p3 = top_part_index[2];
                // double p4 = top_part_index[3];
                switch (lastest)
                {
                    case "1":
                        top_part_index[0] = top_part_index[0] + 0.5;
                        break;
                    case "2":
                        top_part_index[1] = top_part_index[1] + 0.5;
                        break;
                    case "3":
                        top_part_index[2] = top_part_index[2] + 0.5;
                        break;
                    case "4":
                        top_part_index[3] = top_part_index[3] + 0.5;
                        break;
                }

                double m = top_part_index.Max();
                int p = Array.IndexOf(top_part_index, m);
                int n_m;
                int n_p;
                switch (lastest)
                {
                    case "1":
                        top_part_index[0] = top_part_index[0] - 0.5;
                        break;
                    case "2":
                        top_part_index[1] = top_part_index[1] - 0.5;
                        break;
                    case "3":
                        top_part_index[2] = top_part_index[2] - 0.5;
                        break;
                    case "4":
                        top_part_index[3] = top_part_index[3] - 0.5;
                        break;
                }
                switch (p)
                {
                    case 0:
                        top_part = "part_1";
                        n_m = count_part1_num.Max();
                        n_p = Array.IndexOf(count_part1_num, n_m);
                        switch (n_p)
                        {
                            //26,3,35,12,28,7,29,18,22
                            case 0:
                                top_number = "26  0  3  35  ";
                                break;
                            case 1:
                                top_number = "3  26 35  12  ";
                                break;
                            case 2:
                                top_number = "35  12  28  3  ";
                                break;
                            case 3:
                                top_number = "12  28  35  3  ";
                                break;
                            case 4:
                                top_number = "28  7  12  35  ";
                                break;
                            case 5:
                                top_number = "7  18  29  28  ";
                                break;
                            case 6:
                                top_number = "29  22  18  7  ";
                                break;
                            case 7:
                                top_number = "18  22  29  7  ";
                                break;
                            case 8:
                                top_number = "22  9  18  29  ";
                                break;
                        }
                        break;
                    case 1:
                        top_part = "part_2";
                        n_m = count_part2_num.Max();
                        n_p = Array.IndexOf(count_part2_num, n_m);
                        switch (n_p)
                        {
                            //this for part_2 -- 32 15 19 4 21 2 25 17 34
                            case 0:
                                top_number = "32  0  15  19  ";
                                break;
                            case 1:
                                top_number = "15  32  19  4  ";
                                break;
                            case 2:
                                top_number = "19  15  4  21  ";
                                break;
                            case 3:
                                top_number = "4  19  21  2  ";
                                break;
                            case 4:
                                top_number = "21  4  2  25  ";
                                break;
                            case 5:
                                top_number = "2  21  25  17";
                                break;
                            case 6:
                                top_number = "25  2  17  34  ";
                                break;
                            case 7:
                                top_number = "17  2  25  34  ";
                                break;
                            case 8:
                                top_number = "34  6  17  25  ";
                                break;
                        }
                        break;
                    case 2:
                        top_part = "part_3";
                        n_m = count_part3_num.Max();
                        n_p = Array.IndexOf(count_part3_num, n_m);
                        switch (n_p)
                        {
                            //this f0r part3 10 23 8 30 11 36 13 27 6
                            case 0:
                                top_number = "10  5  23  8  ";
                                break;
                            case 1:
                                top_number = "23  10  8  30  ";
                                break;
                            case 2:
                                top_number = "8  23  30  11  ";
                                break;
                            case 3:
                                top_number = "30  8  11  36  ";
                                break;
                            case 4:
                                top_number = "11  30  36  13  ";
                                break;
                            case 5:
                                top_number = "36  13  11  27  ";
                                break;
                            case 6:
                                top_number = "13  36  27  6  ";
                                break;
                            case 7:
                                top_number = "27  6  13  36  ";
                                break;
                            case 8:
                                top_number = "6  34  27  13  ";
                                break;
                        }
                        break;
                    case 3:
                        top_part = "part_4";
                        n_m = count_part4_num.Max();
                        n_p = Array.IndexOf(count_part4_num, n_m);
                        switch (n_p)
                        {
                            //this for part4 9 31 14 20 1 33 16 24 5
                            case 0:
                                top_number = "9  22  31  14  ";
                                break;
                            case 1:
                                top_number = "31  9  14  20  ";
                                break;
                            case 2:
                                top_number = "14  31  20  1  ";
                                break;
                            case 3:
                                top_number = "20  14  31  1  ";
                                break;
                            case 4:
                                top_number = "1  20  33  16  ";
                                break;
                            case 5:
                                top_number = "33  1  16  24  ";
                                break;
                            case 6:
                                top_number = "16  33  24  5  ";
                                break;
                            case 7:
                                top_number = "24  16  5  10  ";
                                break;
                            case 8:
                                top_number = "5  10  24  16  ";
                                break;
                        }
                        break;
                }
                //Predict_num.Clear();
                //Predict_num.Add(top_number);
                //top_part.Remove(p);

                List<double> tmp = new List<double>(top_part_index);
                tmp.RemoveAt(p);
                double a = tmp[0];
                double b = tmp[1];
                double c = tmp[2];
                double m_1 = tmp.Max();
                int p_1 = Array.IndexOf(top_part_index, m_1);
                if (p == p_1)
                {
                    p_1 = Array.LastIndexOf(top_part_index, m_1);
                }

                //double aa = top_part_index[0];
                //double bb = top_part_index[1];
                //double cc = top_part_index[2];
                //double dd = top_part_index[3];
                int n_m_1;
                int n_p_1;

                switch (p_1)
                {
                    case 0:
                        top_part = "part_1";
                        n_m_1 = count_part1_num.Max();
                        n_p_1 = Array.IndexOf(count_part1_num, n_m_1);
                        switch (n_p_1)
                        {
                            //26,3,35,12,28,7,29,18,22
                            case 0:
                                top_number_1 = "26  0  3  35  ";
                                break;
                            case 1:
                                top_number_1 = "3  26 35  12  ";
                                break;
                            case 2:
                                top_number_1 = "35  12  28  3  ";
                                break;
                            case 3:
                                top_number_1 = "12  28  35  3  ";
                                break;
                            case 4:
                                top_number_1 = "28  7  12  35  ";
                                break;
                            case 5:
                                top_number_1 = "7  18  29  28  ";
                                break;
                            case 6:
                                top_number_1 = "29  22  18  7  ";
                                break;
                            case 7:
                                top_number_1 = "18  22  29  7  ";
                                break;
                            case 8:
                                top_number_1 = "22  9  18  29  ";
                                break;
                        }
                        break;
                    case 1:
                        top_part = "part_2";
                        n_m_1 = count_part2_num.Max();
                        n_p_1 = Array.IndexOf(count_part2_num, n_m_1);
                        switch (n_p_1)
                        {
                            //this for part_2 -- 32 15 19 4 21 2 25 17 34
                            case 0:
                                top_number_1 = "32  0  15  19  ";
                                break;
                            case 1:
                                top_number_1 = "15  32  19  4  ";
                                break;
                            case 2:
                                top_number_1 = "19  15  4  21  ";
                                break;
                            case 3:
                                top_number_1 = "4  19  21  2  ";
                                break;
                            case 4:
                                top_number_1 = "21  4  2  25  ";
                                break;
                            case 5:
                                top_number_1 = "2  21  25  17";
                                break;
                            case 6:
                                top_number_1 = "25  2  17  34  ";
                                break;
                            case 7:
                                top_number_1 = "17  2  25  34  ";
                                break;
                            case 8:
                                top_number_1 = "34  6  17  25  ";
                                break;
                        }
                        break;
                    case 2:
                        top_part = "part_3";
                        n_m_1 = count_part3_num.Max();
                        n_p_1 = Array.IndexOf(count_part3_num, n_m_1);
                        switch (n_p_1)
                        {
                            //this f0r part3 10 23 8 30 11 36 13 27 6
                            case 0:
                                top_number_1 = "10  5  23  8  ";
                                break;
                            case 1:
                                top_number_1 = "23  10  8  30  ";
                                break;
                            case 2:
                                top_number_1 = "8  23  30  11  ";
                                break;
                            case 3:
                                top_number_1 = "30  8  11  36  ";
                                break;
                            case 4:
                                top_number_1 = "11  30  36  13  ";
                                break;
                            case 5:
                                top_number_1 = "36  13  11  27  ";
                                break;
                            case 6:
                                top_number_1 = "13  36  27  6  ";
                                break;
                            case 7:
                                top_number_1 = "27  6  13  36  ";
                                break;
                            case 8:
                                top_number_1 = "6  34  27  13  ";
                                break;
                        }
                        break;
                    case 3:
                        top_part = "part_4";
                        n_m_1 = count_part4_num.Max();
                        n_p_1 = Array.IndexOf(count_part4_num, n_m_1);
                        switch (n_p_1)
                        {
                            //this for part4 9 31 14 20 1 33 16 24 5
                            case 0:
                                top_number_1 = "9  22  31  14  ";
                                break;
                            case 1:
                                top_number_1 = "31  9  14  20  ";
                                break;
                            case 2:
                                top_number_1 = "14  31  20  1  ";
                                break;
                            case 3:
                                top_number_1 = "20  14  31  1  ";
                                break;
                            case 4:
                                top_number_1 = "1  20  33  16  ";
                                break;
                            case 5:
                                top_number_1 = "33  1  16  24  ";
                                break;
                            case 6:
                                top_number_1 = "16  33  24  5  ";
                                break;
                            case 7:
                                top_number_1 = "24  16  5  10  ";
                                break;
                            case 8:
                                top_number_1 = "5  10  24  16  ";
                                break;
                        }
                        break;
                }
            }

        }

        private void Part_symbol(String parameter)
        {
            switch (Int32.Parse(parameter))
            {
                case 0:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = " 0 ";
                    PART_S.Add(" 0 ");
                    break;
                //this for part_1  -- 26,3,35,12,28,7,29,18,22
                case 26:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓵";
                    PART_S.Add("⓵");
                    break;
                case 3:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓵";
                    PART_S.Add("⓵");
                    break;
                case 35:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓵";
                    PART_S.Add("⓵");
                    break;
                case 12:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓵";
                    PART_S.Add("⓵");
                    break;
                case 28:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓵";
                    PART_S.Add("⓵");
                    break;
                case 7:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓵";
                    PART_S.Add("⓵");
                    break;
                case 29:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓵";
                    PART_S.Add("⓵");
                    break;
                case 18:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓵";
                    PART_S.Add("⓵");
                    break;
                case 22:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓵";
                    PART_S.Add("⓵");
                    break;

                //this for part_2 -- 32 15 19 4 21 2 25 17 34
                case 32:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓶";
                    PART_S.Add("⓶");
                    break;
                case 15:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓶";
                    PART_S.Add("⓶");
                    break;
                case 19:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓶";
                    PART_S.Add("⓶");
                    break;
                case 4:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓶";
                    PART_S.Add("⓶");
                    break;
                case 21:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓶";
                    PART_S.Add("⓶");
                    break;
                case 2:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓶";
                    PART_S.Add("⓶");
                    break;
                case 25:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓶";
                    PART_S.Add("⓶");
                    break;
                case 17:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓶";
                    PART_S.Add("⓶");
                    break;
                case 34:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓶";
                    PART_S.Add("⓶");
                    break;
                //this f0r part3 10 23 8 30 11 36 13 27 6
                case 10:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓷";
                    PART_S.Add("⓷");
                    break;
                case 23:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓷";
                    PART_S.Add("⓷");
                    break;
                case 8:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓷";
                    PART_S.Add("⓷");
                    break;
                case 30:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓷";
                    PART_S.Add("⓷");
                    break;
                case 11:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓷";
                    PART_S.Add("⓷");
                    break;
                case 36:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓷";
                    PART_S.Add("⓷");
                    break;
                case 13:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓷";
                    PART_S.Add("⓷");
                    break;
                case 27:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓷";
                    PART_S.Add("⓷");
                    break;
                case 6:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓷";
                    PART_S.Add("⓷");
                    break;

                //this for part4 9 31 14 20 1 33 16 24 5
                case 9:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓸";
                    PART_S.Add("⓸");
                    break;
                case 31:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓸";
                    PART_S.Add("⓸");
                    break;
                case 14:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓸";
                    PART_S.Add("⓸");
                    break;
                case 20:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓸";
                    PART_S.Add("⓸");
                    break;
                case 1:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓸";
                    PART_S.Add("⓸");
                    break;
                case 33:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓸";
                    PART_S.Add("⓸");
                    break;
                case 16:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓸";
                    PART_S.Add("⓸");
                    break;
                case 24:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓸";
                    PART_S.Add("⓸");
                    break;
                case 5:
                    No_partsymbol++;
                    back_partsymbol[No_partsymbol - 1] = "⓸";
                    PART_S.Add("⓸");
                    break;
            }
            if (PART_S.Count > 12)
            {
                PART_S.Clear();
            }
        }
        private void Row_symbol(String parameter)
        {
            switch (Int32.Parse(parameter))
            {
                case 0:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = " 0 ";
                    ROW_S.Add(" 0 ");
                    break;
                case 3:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 6:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 9:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 12:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 15:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 18:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 21:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 24:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 27:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 30:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 33:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;
                case 36:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "∆ ";
                    ROW_S.Add("∆ ");
                    break;

                //med
                case 2:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 5:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 8:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 11:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 14:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 17:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 20:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 23:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 26:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 29:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 32:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                case 35:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "■ ";
                    ROW_S.Add("■ ");
                    break;
                //low
                case 1:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 4:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 7:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 10:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 13:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 16:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 19:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 22:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 25:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 28:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 31:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
                case 34:
                    No_rowsymbol++;
                    back_rowsymbol[No_rowsymbol - 1] = "▼";
                    ROW_S.Add("▼");
                    break;
            }
            if (ROW_S.Count > 12)
            {
                ROW_S.Clear();
            }
        }
        private void Dozen_symbol(String parameter)
        {
            switch (Int32.Parse(parameter))
            {
                case 0:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = " 0 ";
                    DOZEN_S.Add(" 0 ");
                    break;

                case 1:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                case 2:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                case 3:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S ");
                    break;
                case 4:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                case 5:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                case 6:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                case 7:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                case 8:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                case 9:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                case 10:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                case 11:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                case 12:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "S";
                    DOZEN_S.Add("S");
                    break;
                //second dozen
                case 13:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 14:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 15:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 16:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 17:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 18:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 19:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 20:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 21:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 22:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 23:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                case 24:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "M";
                    DOZEN_S.Add("M");
                    break;
                //third dozen
                case 25:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 26:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 27:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 28:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 29:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 30:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 31:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 32:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 33:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 34:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 35:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
                case 36:
                    No_dozensymbol++;
                    back_dozensymbol[No_dozensymbol - 1] = "L";
                    DOZEN_S.Add("L");
                    break;
            }
            if (DOZEN_S.Count > 12)
            {
                DOZEN_S.Clear();
            }
        }
        private void Oddeven_symbol(String parameter)
        {
            switch (Int32.Parse(parameter))
            {
                case 0:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = " 0 ";
                    ODDEVEN_S.Add(" 0 ");
                    break;
                //this for part_1  -- 26,3,35,12,28,7,29,18,22
                case 26:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 3:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 35:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 12:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 28:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 7:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 29:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 18:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 22:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;

                //this for part_2 -- 32 15 19 4 21 2 25 17 34
                case 32:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 15:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 19:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 4:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 21:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 2:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 25:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 17:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 34:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                //this f0r part3 10 23 8 30 11 36 13 27 6
                case 10:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 23:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 8:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 30:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 11:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 36:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 13:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 27:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 6:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;

                //this for part4 9 31 14 20 1 33 16 24 5
                case 9:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 31:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 14:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 20:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 1:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 33:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
                case 16:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 24:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "E";
                    ODDEVEN_S.Add("E");
                    break;
                case 5:
                    No_oddevensymbol++;
                    back_oddevensymbol[No_oddevensymbol - 1] = "O";
                    ODDEVEN_S.Add("O");
                    break;
            }
            if (ODDEVEN_S.Count > 12)
            {
                ODDEVEN_S.Clear();
            }
        }
        private void MessageReceived(String parameter)
        {
            Messages.Add(parameter);
        }
        private void Number_show(String parmeter)
        {
            back_resultValue[No_result] = parmeter;
            No_result++;

            Number.Add("Match result " + No_result + "  Number " + back_resultValue[No_result - 1]);
        }
        private void Event_btn(string parameter)
        {
            if (parameter == "Event_predict") //Event_reset  Event_back
            {
                if (Available_num >= 8)
                {
                    Predict_num.Clear();
                    Predict_num.Add(top_number + top_number_1);
                }
                else
                {
                    Predict_num.Clear();
                    Predict_num.Add("Please input result at least 8");
                }
            }
            if (parameter == "Event_reset")
            {
                DOZEN_S.Clear();
                ROW_S.Clear();
                PART_S.Clear();
                ODDEVEN_S.Clear();
                Predict_num.Clear();
                Number.Clear();
                Available_num = 0;
                No_result = 0;
                for (int i = 0; i < 4; i++)
                {
                    top_part_index[i] = 0;
                }
                count_part0_num[0] = 0;

                for (int i = 0; i < 9; i++)
                {

                    count_part1_num[i] = 0;
                    count_part2_num[i] = 0;
                    count_part3_num[i] = 0;
                    count_part4_num[i] = 0;
                }
            }
            if (parameter == "Event_back")
            {
                Number.Clear();
                PART_S.Clear();
                ROW_S.Clear();
                DOZEN_S.Clear();
                ODDEVEN_S.Clear();

                if (No_result > 0)
                {
                    --No_result;
                }
                if (No_partsymbol > 0)
                {
                    --No_partsymbol;
                }
                if (No_rowsymbol > 0)
                {
                    --No_rowsymbol;
                }
                if (No_dozensymbol > 0)
                {
                    --No_dozensymbol;
                }
                if (No_oddevensymbol > 0)
                {
                    --No_oddevensymbol;
                }
                if (Available_num > 0)
                {
                    --Available_num;
                }

                for (int i = 0; i < No_result; i++)
                {
                    Number.Add("Match result " + (i + 1) + "  Number " + back_resultValue[i]);
                    PART_S.Add(back_partsymbol[i]);
                    ROW_S.Add(back_rowsymbol[i]);
                    DOZEN_S.Add(back_dozensymbol[i]);
                    ODDEVEN_S.Add(back_oddevensymbol[i]);

                }
            }
        }
    }
}