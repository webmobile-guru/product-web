﻿using System;
using RouletteSimulator.Core.Enumerations;

namespace RouletteSimulator.Core.Models.BoardModels
{
    /// <summary>
    /// The SplitBet class represents a single split bet.
    /// </summary>
    public class SplitBet : StraightBet
    {
        #region Fields
        
        protected int _secondNumber;

        #endregion

        #region Constructors

        /// <summary>
        /// Default constructor.
        /// </summary>
        public SplitBet() : base()
        {
            _betType = BetType.Split;
        }

        #endregion

        #region Events

        public static event HighLightSplitBet OnHighLightSplitBet;
        public static event ClearHighLightSplitBet OnClearHighLightSplitBet;

        #endregion

        #region Properties

        /// <summary>
        /// Gets the exposure.
        /// </summary>
        public override int Exposure
        {
            get
            {
                return Constants.SplitExposure;
            }
        }

        /// <summary>
        /// Gets the outcome.
        /// </summary>
        public override int Outcome
        {
            get
            {
                return Constants.SplitOutcome;
            }
        }
        
        /// <summary>
        /// Gets or sets the second number to bet on.
        /// </summary>
        public int SecondNumber
        {
            get
            {
                return _secondNumber;
            }
            set
            {
                SetProperty(ref _secondNumber, value);
            }
        }

        /// <summary>
        /// Gets the text label for the bet.
        /// </summary>
        public override string Label
        {
            get
            {
                return string.Empty;
            }
        }

        #endregion

        #region Methods

        /// <summary>
        /// The HighLightBet method is called to highlight the bet.
        /// </summary>
        protected override void HighLightBet()
        {
            OnHighLightSplitBet?.Invoke(this);
        }

        /// <summary>
        /// The ClearHighLightBet method is called to un-highlight the bet.
        /// </summary>
        protected override void ClearHighLightBet()
        {
            OnClearHighLightSplitBet?.Invoke(this);
        }

        /// <summary>
        /// The CalculateWinnings method calculates the winnings for this bet, for a provided winning number.
        /// </summary>
        /// <param name="winningNumber"></param>
        /// <returns></returns>
        public override int CalculateWinnings(int winningNumber)
        {
            try
            {
                return (winningNumber == _firstNumber || winningNumber == _secondNumber) ? CalculateWinnings() : CalculateLosses();
            }
            catch (Exception ex)
            {
                throw new Exception("SplitBet.CalculateWinnings(int winningNumber): " + ex.ToString());
            }
        }

        #endregion
    }
}
