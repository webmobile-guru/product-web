using Prism.Events;
using RouletteSimulator.Core.EventAggregator;
using RouletteSimulator.Core.Models.WheelModels;
using System.Windows.Controls;

namespace ShowWheel.Views
{
    /// <summary>
    /// Interaction logic for ViewA.xaml
    /// </summary>
    public partial class ShowWheelView : UserControl
    {
        #region Fields

        private IEventAggregator _eventAggregator;

        #endregion

        #region Constructor
        public ShowWheelView(IEventAggregator eventAggregator)
        {
            InitializeComponent();

            DataContext = this;                                                             // Set data context (for data binding).
            RouletteWheel = new RouletteWheel(mainGrid, wheelControl, ballControl, lineCanvas); // Initialize the roulette wheel.

            // Listen to events.
            RouletteWheel.OnWheelSpinning += new WheelSpinning(WheelSpinningEventHandler);
            RouletteWheel.OnBallTossed += new BallTossed(BallTossedEventHandler);
            RouletteWheel.OnWinningNumber += new WinningNumber(WinningNumberEventHandler);

            // Event aggregator.
            _eventAggregator = eventAggregator;
            _eventAggregator.GetEvent<SpinWheelEvent>().Subscribe(SpinWheelEventHandler, true);
            _eventAggregator.GetEvent<TossBallEvent>().Subscribe(TossBallEventHandler, true);
            _eventAggregator.GetEvent<BoardClearedEvent>().Subscribe(BoardClearedEventHandler, true);

            // Publish the initial status of the wheel/ball.
            _eventAggregator.GetEvent<WheelSpinningEvent>().Publish(false);
            _eventAggregator.GetEvent<BallTossedEvent>().Publish(false);
            //text
            _eventAggregator.GetEvent<Keyboard_Num>().Subscribe(displayWheelText, true);
            _eventAggregator.GetEvent<Button_Event>().Subscribe(Event_btn);
        }

        private void Event_btn(string obj)
        {
            if (obj == "Event_reset")
            {
                RouletteWheel.ResetWheelText(obj);
                RouletteWheel.ResetWheelLine();
            }
            else if (obj == "Event_back")
            {
                RouletteWheel.BackWheelLine();
            }
        }

        private void displayWheelText(string obj)
        {
            RouletteWheel.WheelText(obj);
        }
        #endregion

        #region Events
        #endregion

        #region Properties

        /// <summary>
        /// Gets the roulette board.
        /// </summary>
        public RouletteWheel RouletteWheel { get; }

        #endregion

        #region Methods

        /// <summary>
        /// The SpinWheelEventHandler handles an incoming SpinWheelEvent event.
        /// </summary>
        private void SpinWheelEventHandler()
        {
            RouletteWheel.SpinWheel();  // Spin the wheel.
        }

        /// <summary>
        /// The TossBallEventHandler handles an incoming TossBallEvent event.
        /// </summary>
        private void TossBallEventHandler()
        {
            RouletteWheel.TossBall();   // Toss the ball.
        }

        /// <summary>
        /// The BoardClearedEventHandler handles an incoming BoardClearedEvent event.
        /// </summary>
        private void BoardClearedEventHandler()
        {
            RouletteWheel.RetrieveBall();   // Retrieve the ball.
        }

        /// <summary>
        /// The WheelSpinningEventHandler method is called to handle an OnWheelSpinning event.
        /// </summary>
        /// <param name="wheelSpinning"></param>
        private void WheelSpinningEventHandler(bool wheelSpinning)
        {
            _eventAggregator.GetEvent<WheelSpinningEvent>().Publish(wheelSpinning); // Update the status of the wheel.
        }

        /// <summary>
        /// The BallTossedEventHandler method is called to handle an OnBallTossed event.
        /// </summary>
        /// <param name="ballTossed"></param>
        private void BallTossedEventHandler(bool ballTossed)
        {
            _eventAggregator.GetEvent<BallTossedEvent>().Publish(ballTossed);   // Update the status of the ball.
        }

        /// <summary>
        /// The WinningNumberEventHandler method is called to handle an OnWinningNumber event.
        /// </summary>
        /// <param name="winningNumber"></param>
        private void WinningNumberEventHandler(Pocket winningNumber)
        {
            _eventAggregator.GetEvent<WinningNumberEvent>().Publish(winningNumber); // Publish the winning number.
        }

        #endregion
    }
}

