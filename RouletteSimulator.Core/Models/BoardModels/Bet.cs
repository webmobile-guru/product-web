﻿using Prism.Commands;
using Prism.Mvvm;
using RouletteSimulator.Core.Enumerations;
using RouletteSimulator.Core.Models.ChipModels;
using System;
using System.Collections.ObjectModel;
using System.Linq;
using System.Media;
using System.Windows.Controls;

namespace RouletteSimulator.Core.Models.BoardModels
{
    /// <summary>
    /// The Bet class represents a single bet.
    /// It is an abstract class.
    /// </summary>
    public abstract class Bet : BindableBase
    {
        #region Fields

        protected BetType _betType;
        protected int _betAmount;
        
        #endregion

        #region Constructors

        /// <summary>
        /// Default constructor.
        /// </summary>
        public Bet()
        {
            _betAmount = 0;
            SelectedChip = ChipType.Undefined;
            Chips = new ObservableCollection<Chip>();

            // Commands.
            HighLightBetCommand = new DelegateCommand(HighLightBet);
            ClearHighLightBetCommand = new DelegateCommand(ClearHighLightBet);
            PlaceBetCommand = new DelegateCommand(PlaceBet);
            RemoveLastChipCommand = new DelegateCommand(RemoveLastChip);
        }

        /// <summary>
        /// Constructor.
        /// Creates a Bet for the provided bet type.
        /// </summary>
        /// <param name="betType"></param>
        public Bet(BetType betType) : this()
        {
            _betType = betType;
        }

        #endregion

        #region Events

        public static event BetPlaced OnBetPlaced;

        #endregion

        #region Properties

        /// <summary>
        /// Gets or sets the current selected chip type.
        /// </summary>
        public static ChipType SelectedChip
        {
            get;
            set;
        }

        /// <summary>
        /// Gets or sets the current place bets.
        /// </summary>
        public static bool PlaceBets
        {
            get;
            set;
        }

        /// <summary>
        /// Gets the bet type.
        /// </summary>
        public BetType BetType
        {
            get
            {
                return _betType;
            }
            set
            {
                SetProperty(ref _betType, value);
            }
        }

        /// <summary>
        /// Gets or sets the bet amount.
        /// </summary>
        public int BetAmount
        {
            get
            {
                return _betAmount;
            }
            protected set
            {
                if (value >= 0)
                {
                    SetProperty(ref _betAmount, value);
                }
            }
        }
        
        /// <summary>
        /// Gets the exposure.
        /// </summary>
        public abstract int Exposure
        {
            get;
        }

        /// <summary>
        /// Gets the outcome.
        /// </summary>
        public abstract int Outcome
        {
            get;
        }

        /// <summary>
        /// Gets the collection of chips.
        /// </summary>
        public ObservableCollection<Chip> Chips { get; }

        /// <summary>
        /// Gets or sets the HighLightBetCommand.
        /// </summary>
        public DelegateCommand HighLightBetCommand { get; private set; }

        /// <summary>
        /// Gets or sets the ClearHighLightBetCommand.
        /// </summary>
        public DelegateCommand ClearHighLightBetCommand { get; private set; }

        /// <summary>
        /// Gets or sets the PlaceBetCommand.
        /// </summary>
        public DelegateCommand PlaceBetCommand { get; private set; }

        /// <summary>
        /// Gets or sets the RemoveLastChipCommand.
        /// </summary>
        public DelegateCommand RemoveLastChipCommand { get; private set; }

        /// <summary>
        /// Gets the text label for the bet.
        /// </summary>
        public abstract string Label
        {
            get;
        }

        /// <summary>
        /// Gets the Border control for this chip.
        /// </summary>
        public Border Border
        {
            get;
            private set;
        }
        
        #endregion

        #region Methods

        /// <summary>
        /// The HighLightBet method is called to highlight the bet.
        /// </summary>
        protected abstract void HighLightBet();

        /// <summary>
        /// The ClearHighLightBet method is called to un-highlight the bet.
        /// </summary>
        protected abstract void ClearHighLightBet();

        /// <summary>
        /// The PlaceBet method is called to place a bet for the current selected chip.
        /// </summary>
        public void PlaceBet()
        {
            try
            {
                if (PlaceBets && SelectedChip != ChipType.Undefined)
                {
                    BetAmount = BetAmount + Chip.GetChipValue(SelectedChip);
                    
                    // Create a chip at the bet location.
                    Chip chip = null;
                    switch (Bet.SelectedChip)
                    {
                        case ChipType.One:
                            chip = new One(Chips.Count());
                            break;
                        case ChipType.Five:
                            chip = new Five(Chips.Count());
                            break;
                        case ChipType.TwentyFive:
                            chip = new TwentyFive(Chips.Count());
                            break;
                        case ChipType.OneHundred:
                            chip = new OneHundred(Chips.Count());
                            break;
                        case ChipType.FiveHundred:
                            chip = new FiveHundred(Chips.Count());
                            break;
                        case ChipType.OneThousand:
                            chip = new OneThousand(Chips.Count());
                            break;
                        case ChipType.FiveThousand:
                            chip = new FiveThousand(Chips.Count());
                            break;
                        case ChipType.TwentyFiveThousand:
                            chip = new TwentyFiveThousand(Chips.Count());
                            break;
                        case ChipType.OneHundredThousand:
                            chip = new OneHundredThousand(Chips.Count());
                            break;
                        case ChipType.FiveHundredThousand:
                            chip = new FiveHundredThousand(Chips.Count());
                            break;
                    }

                    if (chip != null)
                    {
                        OnBetPlaced?.Invoke(chip.Value);    // Notify that the bet has been placed.
                        Chips.Add(chip);                    // Add the chip to the bet.
                        CombineChips();                     // Combine the chips.
                    }
                }
            }
            catch (Exception ex)
            {
                throw new Exception("Bet.PlaceBet(object parameter): " + ex.ToString());
            }
        }

        /// <summary>
        /// The RemoveLastChip method is called to remove the last chip placed on the bet.
        /// </summary>
        public void RemoveLastChip()
        {
            try
            {
                if (Chips.Count > 0)
                {
                    Chip chip = Chips[Chips.Count - 1];     // Retrieve the last chip.
                    BetAmount = BetAmount - chip.Value;     // Update the bet amount.
                    OnBetPlaced?.Invoke(-1 * chip.Value);   // Notify that the last chip as been removed (place a negative bet).
                    Chips.RemoveAt(Chips.Count - 1);        // Remove the last chip from the bet.
                }
            }
            catch (Exception ex)
            {
                throw new Exception("Bet.RemoveLastChip(): " + ex.ToString());
            }
        }
        
        /// <summary>
        /// The ClearBet method is called to clear the bet amount.
        /// </summary>
        public void ClearBet()
        {
            BetAmount = 0;
            Chips.Clear();
        }

        /// <summary>
        /// The CalculateWinnings method calculates the winnings for this bet.
        /// </summary>
        /// <returns></returns>
        protected int CalculateWinnings()
        {
            if (BetAmount > 0)
            {
                return (Exposure + Outcome) * BetAmount;
            }
            else
            {
                return 0;
            }
        }

        /// <summary>
        /// The CalculateLosses method calculates the losses for this bet.
        /// </summary>
        /// <returns></returns>
        protected int CalculateLosses()
        {
            if (BetAmount > 0)
            {
                return -1 * BetAmount;
            }
            else
            {
                return 0;
            }
        }

        /// <summary>
        /// The CombineChips method is called to clean up the stack of chips.
        /// Collection of smaller value chips are combined into larger value chips.
        /// </summary>
        public void CombineChips()
        {
            Chips.Clear();  // Clear the current stack of chips.

            int quotient = BetAmount / Chip.GetChipValue(ChipType.FiveHundredThousand);
            int remainder = BetAmount % Chip.GetChipValue(ChipType.FiveHundredThousand);
            if (quotient > 0)
            {
                for (int i = 0; i < quotient; i++)
                {
                    Chips.Add(new FiveHundredThousand(Chips.Count));
                }
            }

            quotient = remainder / Chip.GetChipValue(ChipType.OneHundredThousand);
            remainder = remainder % Chip.GetChipValue(ChipType.OneHundredThousand);
            if (quotient > 0)
            {
                for (int i = 0; i < quotient; i++)
                {
                    Chips.Add(new OneHundredThousand(Chips.Count));
                }
            }

            quotient = remainder / Chip.GetChipValue(ChipType.TwentyFiveThousand);
            remainder = remainder % Chip.GetChipValue(ChipType.TwentyFiveThousand);
            if (quotient > 0)
            {
                for (int i = 0; i < quotient; i++)
                {
                    Chips.Add(new TwentyFiveThousand(Chips.Count));
                }
            }

            quotient = remainder / Chip.GetChipValue(ChipType.FiveThousand);
            remainder = remainder % Chip.GetChipValue(ChipType.FiveThousand);
            if (quotient > 0)
            {
                for (int i = 0; i < quotient; i++)
                {
                    Chips.Add(new FiveThousand(Chips.Count));
                }
            }

            quotient = remainder / Chip.GetChipValue(ChipType.OneThousand);
            remainder = remainder % Chip.GetChipValue(ChipType.OneThousand);
            if (quotient > 0)
            {
                for (int i = 0; i < quotient; i++)
                {
                    Chips.Add(new OneThousand(Chips.Count));
                }
            }

            quotient = remainder / Chip.GetChipValue(ChipType.FiveHundred);
            remainder = remainder % Chip.GetChipValue(ChipType.FiveHundred);
            if (quotient > 0)
            {
                for (int i = 0; i < quotient; i++)
                {
                    Chips.Add(new FiveHundred(Chips.Count));
                }
            }

            quotient = remainder / Chip.GetChipValue(ChipType.OneHundred);
            remainder = remainder % Chip.GetChipValue(ChipType.OneHundred);
            if (quotient > 0)
            {
                for (int i = 0; i < quotient; i++)
                {
                    Chips.Add(new OneHundred(Chips.Count));
                }
            }

            quotient = remainder / Chip.GetChipValue(ChipType.TwentyFive);
            remainder = remainder % Chip.GetChipValue(ChipType.TwentyFive);
            if (quotient > 0)
            {
                for (int i = 0; i < quotient; i++)
                {
                    Chips.Add(new TwentyFive(Chips.Count));
                }
            }

            quotient = remainder / Chip.GetChipValue(ChipType.Five);
            remainder = remainder % Chip.GetChipValue(ChipType.Five);
            if (quotient > 0)
            {
                for (int i = 0; i < quotient; i++)
                {
                    Chips.Add(new Five(Chips.Count));
                }
            }

            quotient = remainder / Chip.GetChipValue(ChipType.One);
            remainder = remainder % Chip.GetChipValue(ChipType.One);
            if (quotient > 0)
            {
                for (int i = 0; i < quotient; i++)
                {
                    Chips.Add(new One(Chips.Count));
                }
            }
        }

        /// <summary>
        /// The CalculateWinnings method calculates the winnings for this bet, for a provided winning number.
        /// </summary>
        /// <param name="winningNumber"></param>
        /// <returns></returns>
        public abstract int CalculateWinnings(int winningNumber);

        #endregion
    }
}
