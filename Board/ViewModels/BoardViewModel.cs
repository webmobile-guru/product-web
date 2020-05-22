using Prism.Commands;
using Prism.Events;
using Prism.Mvvm;
using RouletteSimulator.Core.Enumerations;
using RouletteSimulator.Core.EventAggregator;
using RouletteSimulator.Core.Models.BoardModels;
using RouletteSimulator.Core.Models.WheelModels;

namespace Board.ViewModels
{
    /// <summary>
    /// The BoardViewModel class represents the view model for the Board module.
    /// </summary>
    public class BoardViewModel : BindableBase
    {
        #region Fields

        IEventAggregator _eventAggregator;
        private string _message = "Messgae to send";

        public string Message
        {
            get { return _message; }
            set { SetProperty(ref _message, value); }
        }

        public DelegateCommand SendMessageCommand
        {
            get; private set;
        }

        public DelegateCommand zero
        {
            get;
            private set;
        }
        public DelegateCommand one
        {
            get;
            private set;
        }

        public DelegateCommand two
        {
            get;
            private set;
        }

        public DelegateCommand three
        {
            get;
            private set;
        }

        public DelegateCommand four
        {
            get;
            private set;
        }
        public DelegateCommand five
        {
            get;
            private set;
        }
        public DelegateCommand six
        {
            get;
            private set;
        }
        public DelegateCommand seven
        {
            get;
            private set;
        }
        public DelegateCommand eight
        {
            get;
            private set;
        }
        public DelegateCommand nine
        {
            get;
            private set;
        }
        public DelegateCommand ten
        {
            get;
            private set;
        }
        public DelegateCommand eleven
        {
            get;
            private set;
        }
        public DelegateCommand twelve
        {
            get;
            private set;
        }
        public DelegateCommand thirteen
        {
            get;
            private set;
        }
        public DelegateCommand fourteen
        {
            get;
            private set;
        }
        public DelegateCommand fifteen
        {
            get;
            private set;
        }
        public DelegateCommand sixteen
        {
            get;
            private set;
        }
        public DelegateCommand seventeen
        {
            get;
            private set;
        }
        public DelegateCommand eighteen
        {
            get;
            private set;
        }
        public DelegateCommand nineteen
        {
            get;
            private set;
        }
        public DelegateCommand twenty
        {
            get;
            private set;
        }
        public DelegateCommand twentyone
        {
            get;
            private set;
        }
        public DelegateCommand twentytwo
        {
            get;
            private set;
        }
        public DelegateCommand twentythree
        {
            get;
            private set;
        }
        public DelegateCommand twentyfour
        {
            get;
            private set;
        }
        public DelegateCommand twentyfive
        {
            get;
            private set;
        }
        public DelegateCommand twentysix
        {
            get;
            private set;
        }
        public DelegateCommand twentyseven
        {
            get;
            private set;
        }
        public DelegateCommand twentyeight
        {
            get;
            private set;
        }
        public DelegateCommand twentynine
        {
            get;
            private set;
        }
        public DelegateCommand thirty
        {
            get;
            private set;
        }
        public DelegateCommand thiryone
        {
            get;
            private set;
        }
        public DelegateCommand thirtytwo
        {
            get;
            private set;
        }
        public DelegateCommand thirythree
        {
            get;
            private set;
        }
        public DelegateCommand thirtyfour
        {
            get;
            private set;
        }
        public DelegateCommand thirtyfive
        {
            get;
            private set;
        }
        public DelegateCommand thirfysix
        {
            get;
            private set;
        }

        //FOR EVEN BUTTON
        public DelegateCommand EVEN
        {
            get;
            private set;
        }
        public DelegateCommand ODD
        {
            get;
            private set;
        }
        public DelegateCommand RED
        {
            get;
            private set;
        }
        public DelegateCommand BLACK
        {
            get;
            private set;
        }
        public DelegateCommand SDOZEN
        {
            get;
            private set;
        }
        public DelegateCommand MDOZEN
        {
            get;
            private set;
        }
        public DelegateCommand LDOZEN
        {
            get;
            private set;
        }


        #endregion

        #region Constructors

        /// <summary>
        ///  Constructor.
        /// </summary>
        /// <param name="eventAggregator"></param>
        public BoardViewModel(IEventAggregator eventAggregator)
        {
            RouletteBoard = new RouletteBoard();    // Models.

            // Listen to events.
            Bet.OnBetPlaced += new BetPlaced(BetPlacedEventHandler);
            RouletteBoard.OnBoardCleared += new BoardCleared(BoardClearedEventHandler);

            // Event aggregator.
            _eventAggregator = eventAggregator;
            _eventAggregator.GetEvent<SelectedChipEvent>().Subscribe(SelectedChipEventHandler, true);
            _eventAggregator.GetEvent<WinningNumberEvent>().Subscribe(WinningNumberEventHandler, true);
            _eventAggregator.GetEvent<BetClearedEvent>().Subscribe(BetClearedEventHandler, true);
            _eventAggregator.GetEvent<PlaceBetsEvent>().Subscribe(PlaceBetsEventHandler, true);

            SendMessageCommand = new DelegateCommand(SendMessage);

            zero = new DelegateCommand(send_zero);
            one = new DelegateCommand(send_one);
            two = new DelegateCommand(send_two);
            three = new DelegateCommand(send_three);
            four = new DelegateCommand(send_four);
            five = new DelegateCommand(send_five);
            six = new DelegateCommand(send_six);
            seven = new DelegateCommand(send_seven);
            eight = new DelegateCommand(send_eight);
            nine = new DelegateCommand(send_nine);
            ten = new DelegateCommand(send_ten);
            eleven = new DelegateCommand(send_eleven);
            twelve = new DelegateCommand(send_twelve);
            thirteen = new DelegateCommand(send_thirteen);
            fourteen = new DelegateCommand(send_fourteen);
            fifteen = new DelegateCommand(send_fifteen);
            sixteen = new DelegateCommand(send_sixteen);
            seventeen = new DelegateCommand(send_seventeen);
            eighteen = new DelegateCommand(send_eighteen);
            nineteen = new DelegateCommand(send_nineteen);
            twenty = new DelegateCommand(send_twenty);
            twentyone = new DelegateCommand(send_twentyone);
            twentytwo = new DelegateCommand(send_twentytwo);
            twentythree = new DelegateCommand(send_twentythree);
            twentyfour = new DelegateCommand(send_twentyfour);
            twentyfive = new DelegateCommand(send_twentyfive);
            twentysix = new DelegateCommand(send_twentysix);
            twentyseven = new DelegateCommand(send_twentyseven);
            twentyeight = new DelegateCommand(send_twentyeight);
            twentynine = new DelegateCommand(send_twentynine);
            thirty = new DelegateCommand(send_thirty);
            thiryone = new DelegateCommand(send_thirtyone);
            thirtytwo = new DelegateCommand(send_thirtytwo);
            thirythree = new DelegateCommand(send_thirtythree);
            thirtyfour = new DelegateCommand(send_thirtyfour);
            thirtyfive = new DelegateCommand(send_thirtyfive);
            thirfysix = new DelegateCommand(send_thirtysix);

            //EVEN = new DelegateCommand(send_even);
            //ODD = new DelegateCommand(send_odd);
            //RED = new DelegateCommand(send_red);
            //BLACK = new DelegateCommand(send_black);

            //SDOZEN = new DelegateCommand(send_sdozen);
            // MDOZEN = new DelegateCommand(send_mdozen);
            //LDOZEN = new DelegateCommand(send_ldozen);

        }
        private void SendMessage()
        {
            _eventAggregator.GetEvent<MessageSentEvent>().Publish(Message);
        }
        private void send_zero()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("0");
        }
        private void send_one()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("1");
        }
        private void send_two()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("2");
        }
        private void send_three()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("3");
        }
        private void send_four()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("4");
        }
        private void send_five()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("5");
        }
        private void send_six()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("6");
        }
        private void send_seven()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("7");
        }
        private void send_eight()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("8");
        }
        private void send_nine()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("9");
        }
        private void send_ten()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("10");
        }
        private void send_eleven()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("11");
        }
        private void send_twelve()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("12");
        }
        private void send_thirteen()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("13");
        }
        private void send_fourteen()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("14");
        }
        private void send_fifteen()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("15");
        }
        private void send_sixteen()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("16");
        }
        private void send_seventeen()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("17");
        }
        private void send_eighteen()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("18");
        }
        private void send_nineteen()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("19");
        }
        private void send_twenty()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("20");
        }
        private void send_twentyone()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("21");
        }
        private void send_twentytwo()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("22");
        }
        private void send_twentythree()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("23");
        }
        private void send_twentyfour()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("24");
        }
        private void send_twentyfive()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("25");
        }
        private void send_twentysix()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("26");
        }
        private void send_twentyseven()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("27");
        }
        private void send_twentyeight()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("28");
        }
        private void send_twentynine()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("29");
        }
        private void send_thirty()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("30");
        }
        private void send_thirtyone()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("31");
        }
        private void send_thirtytwo()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("32");
        }
        private void send_thirtythree()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("33");
        }
        private void send_thirtyfour()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("34");
        }
        private void send_thirtyfive()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("35");
        }
        private void send_thirtysix()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("36");
        }

        //for special
        /* private void send_even()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("spe_even");
        }
        private void send_odd()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("spe_odd");
        }
        private void send_red()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("spe_red");
        }
        private void send_black()
        {
            _eventAggregator.GetEvent<Keyboard_Num>().Publish("spe_black");
        }
        */
        //dozen
        //private void send_sdozen()
        //{
        //    _eventAggregator.GetEvent<Keyboard_Num>().Publish("spe_sdozen");
        // }
        // private void send_mdozen()
        //{
        //    _eventAggregator.GetEvent<Keyboard_Num>().Publish("spe_mdozen");
        // }
        //private void send_ldozen()
        //{
        //     _eventAggregator.GetEvent<Keyboard_Num>().Publish("spe_ldozen");
        // }


        #endregion

        #region Events
        #endregion

        #region Properties

        /// <summary>
        /// Gets the roulette board.
        /// </summary>
        public RouletteBoard RouletteBoard { get; }

        #endregion

        #region Methods

        /// <summary>
        /// The BetPlacedEventHandler handles an incoming OnBetPlaced event.
        /// </summary>
        /// <param name="betAmount"></param>
        private void BetPlacedEventHandler(int betAmount)
        {
            _eventAggregator.GetEvent<BetPlacedEvent>().Publish(betAmount); // Publish the bet.
        }

        /// <summary>
        /// The BoardClearedEventHandler handles an incoming OnBoardCleared event.
        /// </summary>
        private void BoardClearedEventHandler()
        {
            _eventAggregator.GetEvent<BoardClearedEvent>().Publish();   // Publish the board cleared event.
        }

        /// <summary>
        /// The SelectedChipEventHandler handles an incoming SelectedChipEvent event.
        /// </summary>
        /// <param name="selectedChip"></param>
        private void SelectedChipEventHandler(ChipType selectedChip)
        {
            Bet.SelectedChip = selectedChip;    // Update chip selection.
        }

        /// <summary>
        /// The WinningNumberEventHandler handles an incoming WinningNumberEvent event.
        /// </summary>
        /// <param name="winningNumber"></param>
        private void WinningNumberEventHandler(Pocket winningNumber)
        {
            _eventAggregator.GetEvent<PayWinningsEvent>().Publish(RouletteBoard.CalculateWinnings(winningNumber.Number));  // Publish the winnings.
        }

        /// <summary>
        /// The BetClearedEventHandler handles an incoming BetClearedEvent event.
        /// </summary>
        private void BetClearedEventHandler()
        {
            RouletteBoard.ClearBets();  // Clear all bets.
        }

        /// <summary>
        /// The PlaceBetsEventHandler handles an incoming PlaceBetsEvent event.
        /// </summary>
        private void PlaceBetsEventHandler(bool placeBets)
        {
            Bet.PlaceBets = placeBets;
        }

        #endregion
    }
}
