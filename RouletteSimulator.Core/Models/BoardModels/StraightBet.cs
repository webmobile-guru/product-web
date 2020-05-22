﻿using System;
using System.Linq;
using RouletteSimulator.Core.Enumerations;

namespace RouletteSimulator.Core.Models.BoardModels
{
    /// <summary>
    /// The StraightBet class represents a single straight bet.
    /// </summary>
    public class StraightBet : Bet
    {
        #region Fields
        
        protected int _firstNumber;
        private bool _isHighLighted;
        private bool _isWinningNumber;

        #endregion

        #region Constructors

        /// <summary>
        /// Default constructor.
        /// </summary>
        public StraightBet() : base()
        {
            _betType = BetType.Straight;
            _isHighLighted = false;
            _isWinningNumber = false;
        }
        
        #endregion

        #region Events
        #endregion

        #region Properties

        /// <summary>
        /// 
        /// 
        /// 
        /// Gets the exposure.
        /// </summary>
        public override int Exposure
        {
            get
            {
                return Constants.StraightExposure;
            }
        }

        /// <summary>
        /// Gets the outcome.
        /// </summary>
        public override int Outcome
        {
            get
            {
                return Constants.StraightOutcome;
            }
        }

        /// <summary>
        /// Gets or sets the first number to bet on.
        /// </summary>
        public int FirstNumber
        {
            get
            {
                return _firstNumber;
            }
            set
            {
                SetProperty(ref _firstNumber, value);
            }
        }

        /// <summary>
        /// Returns a boolan flag indicating if this is a red number.
        /// </summary>
        public bool IsRedNumber
        {
            get
            {
                return Constants.RedWinningNumbers.Contains(FirstNumber);
            }
        }

        /// <summary>
        /// Returns a boolan flag indicating if this is a black number.
        /// </summary>
        public bool IsBlackNumber
        {
            get
            {
                return Constants.BlackWinningNumbers.Contains(FirstNumber);
            }
        }

        /// <summary>
        /// Gets or sets the highlighted flag.
        /// </summary>
        public bool IsHighLighted
        {
            get
            {
                return _isHighLighted;
            }
            set
            {
                SetProperty(ref _isHighLighted, value);
            }
        }

        /// <summary>
        /// Gets or sets the winning number flag.
        /// </summary>
        public bool IsWinningNumber
        {
            get
            {
                return _isWinningNumber;
            }
            set
            {
                SetProperty(ref _isWinningNumber, value);
            }
        }

        /// <summary>
        /// Gets the text label for the bet.
        /// </summary>
        public override string Label
        {
            get
            {
                return FirstNumber.ToString();
            }
        }

        #endregion

        #region Methods

        /// <summary>
        /// The HighLightBet method is called to highlight the bet.
        /// </summary>
        protected override void HighLightBet()
        {
            IsHighLighted = true;
        }

        /// <summary>
        /// The ClearHighLightBet method is called to un-highlight the bet.
        /// </summary>
        protected override void ClearHighLightBet()
        {
            IsHighLighted = false;
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
                int winnings = 0;

                if (winningNumber == _firstNumber)
                {
                    IsWinningNumber = true;
                    winnings = CalculateWinnings();
                }
                else
                {
                    winnings = CalculateLosses();
                }

                return winnings;
            }
            catch (Exception ex)
            {
                throw new Exception("StraightBet.CalculateWinnings(int winningNumber): " + ex.ToString());
            }
        }
        
        #endregion
    }
}
