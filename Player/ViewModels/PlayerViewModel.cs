﻿using Prism.Events;
using Prism.Mvvm;
using RouletteSimulator.Core.Enumerations;
using RouletteSimulator.Core.EventAggregator;
using RouletteSimulator.Core.Models.PersonModels;

namespace Player.ViewModels
{
    /// <summary>
    /// The PlayerViewModel class represents the view model for the Player module.
    /// </summary>
    public class PlayerViewModel : BindableBase
    {
        #region Fields

        private IEventAggregator _eventAggregator;

        #endregion

        #region Constructors

        /// <summary>
        /// Constructor.
        /// </summary>
        /// <param name="eventAggregator"></param>
        public PlayerViewModel(IEventAggregator eventAggregator)
        {
            RoulettePlayer = new RoulettePlayer();    // Models.

            // Listen to events.
            RoulettePlayer.OnChipSelected += new ChipSelected(ChipSelectedEventHandler);
            RoulettePlayer.OnClearBets += new ClearBets(ClearBetsEventHandler);

            // Event aggregator.
            _eventAggregator = eventAggregator;
            _eventAggregator.GetEvent<BetPlacedEvent>().Subscribe(BetPlacedEventHandler, true);
            _eventAggregator.GetEvent<PlaceBetsEvent>().Subscribe(PlaceBetsEventHandler, true);
            _eventAggregator.GetEvent<PayWinningsEvent>().Subscribe(PayWinningsEventHandler, true);
        }

        #endregion

        #region Events
        #endregion

        #region Properties

        /// <summary>
        /// Gets the roulette player.
        /// </summary>
        public RoulettePlayer RoulettePlayer { get; }

        #endregion

        #region Methods

        /// <summary>
        /// The ChipSelectedEventHandler method is called to handle an OnChipSelected event.
        /// </summary>
        /// <param name="selectedChip"></param>
        private void ChipSelectedEventHandler(ChipType selectedChip)
        {
            _eventAggregator.GetEvent<SelectedChipEvent>().Publish(selectedChip);   // Publish the selected chip.
        }

        /// <summary>
        /// The ClearBetsEventHandler method is called to handle an OnClearBets event.
        /// </summary>
        private void ClearBetsEventHandler()
        {
            _eventAggregator.GetEvent<BetClearedEvent>().Publish(); // Publish the bet cleared event.
        }

        /// <summary>
        /// The ChipSelectedEventHandler method is called to handle a BetPlacedEvent event.
        /// </summary>
        /// <param name="betAmount"></param>
        private void BetPlacedEventHandler(int betAmount)
        {
            RoulettePlayer.DeductBet(betAmount);    // Deduct the bet from the player.
        }

        /// <summary>
        /// The PlaceBetsEventHandler method is called to handle a PlaceBetsEvent event.
        /// </summary>
        /// <param name="placeBets"></param>
        private void PlaceBetsEventHandler(bool placeBets)
        {
            RoulettePlayer.PlaceBets = placeBets;   // Apply the current place bets status.
        }

        /// <summary>
        /// The PayWinningsEventHandler method is called to handle a PayWinningsEvent event.
        /// </summary>
        /// <param name="winnings"></param>
        private void PayWinningsEventHandler(int winnings)
        {
            RoulettePlayer.ReceiveWinnings(winnings);   // Pay the winnings to the player.
        }

        #endregion
    }
}
