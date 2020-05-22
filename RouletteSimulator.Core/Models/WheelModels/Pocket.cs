﻿using Prism.Mvvm;
using System;
using System.Linq;
using System.Windows.Media;

namespace RouletteSimulator.Core.Models.WheelModels
{
    /// <summary>
    /// The Pocket class represents a single pocket on a roulette wheel.
    /// </summary>
    public class Pocket : BindableBase
    {
        #region Fields

        private int _number;
        private double _widthPixels;
        public double _xPositionPixels;
        public double _yPositionPixels;
        private double _centerPointXPixels;
        private double _centerPointYPixels;
        private double _inputyPositionPixels;
        private double _replaceyPositionPixels;
        private int _replace_count_num;
        private string _Visibility = "Hidden";
        private double _imagePositionPixels;
        private double _lineX1Position;
        private double _lineY1Position;
        private double _lineX2Position;
        private double _lineY2Position;
        #endregion

        #region Constructors

        /// <summary>
        /// Constructor.
        /// </summary>
        public Pocket()
        {
            Points = new PointCollection();
        }

        /// <summary>
        /// Copy constructor.
        /// </summary>
        /// <param name="pocket"></param>
        public Pocket(Pocket pocket)
        {
            try
            {
                if (pocket == null)
                {
                    throw new Exception("pocket can not be null.");
                }

                _number = pocket.Number;
                _widthPixels = pocket.WidthPixels;
                _xPositionPixels = pocket.XPositionPixels;
                _yPositionPixels = pocket.YPositionPixels;
                _centerPointXPixels = pocket.CenterPointXPixels;
                _centerPointYPixels = pocket.CenterPointYPixels;
                _inputyPositionPixels = pocket.InputYPositionPixels;
                _replaceyPositionPixels = pocket.ReplaceYPositionPixels;
                _replace_count_num = pocket.ReplaceCountNum;
                _Visibility = pocket.Visibility;
            }
            catch (Exception ex)
            {
                throw new Exception("Pocket(Pocket pocket): " + ex.ToString());
            }
        }

        #endregion

        #region Events
        #endregion

        #region Properties

        /// <summary>
        /// Gets or sets the first number to bet on.
        /// </summary>
        public int Number
        {
            get
            {
                return _number;
            }
            set
            {
                SetProperty(ref _number, value);
            }
        }

        /// <summary>
        /// Returns a boolan flag indicating if this is a green number.
        /// </summary>
        public bool IsGreenNumber
        {
            get
            {
                return Number == Constants.Zero;
            }
        }

        /// <summary>
        /// Returns a boolan flag indicating if this is a red number.
        /// </summary>
        public bool IsRedNumber
        {
            get
            {
                return Constants.RedWinningNumbers.Contains(Number);
            }
        }

        /// <summary>
        /// Returns a boolan flag indicating if this is a black number.
        /// </summary>
        public bool IsBlackNumber
        {
            get
            {
                return Constants.BlackWinningNumbers.Contains(Number);
            }
        }

        /// <summary>
        /// Gets the text label for the pocket.
        /// </summary>
        public string Label
        {
            get
            {
                return Number.ToString();
            }

        }

        public int ReplaceCountNum
        {
            get { return _replace_count_num; }
            set { SetProperty(ref _replace_count_num, value); }
        }
        /// <summary>
        /// Gets or sets the x-position in pixels.
        /// </summary>
        public double XPositionPixels
        {
            get
            {
                return _xPositionPixels;
            }
            set
            {
                SetProperty(ref _xPositionPixels, value);
            }
        }

        public double ImageYPositionPixels
        {
            get { return _imagePositionPixels; }
            set { SetProperty(ref _imagePositionPixels, value); }
        }

        /// <summary>
        /// Gets or sets the y-position in pixels.
        /// </summary>
        public double YPositionPixels
        {
            get
            {
                return _yPositionPixels;
            }
            set
            {
                SetProperty(ref _yPositionPixels, value);
            }
        }

        public double InputYPositionPixels
        {
            get
            {
                return _inputyPositionPixels;
            }
            set
            {
                SetProperty(ref _inputyPositionPixels, value);
            }
        }

        /// <summary>
        /// Gets or sets the pocket width in pixels.
        /// </summary>
        public double WidthPixels
        {
            get
            {
                return _widthPixels;
            }
            set
            {
                SetProperty(ref _widthPixels, value);
            }
        }

        /// <summary>
        /// Gets or sets the center point x-coordinate in pixels.
        /// </summary>
        public double CenterPointXPixels
        {
            get
            {
                return _centerPointXPixels;
            }
            private set
            {
                SetProperty(ref _centerPointXPixels, value);
            }
        }

        /// <summary>
        /// Gets or sets the wheel center point y-coordinate in pixels.
        /// </summary>
        public double CenterPointYPixels
        {
            get
            {
                return _centerPointYPixels;
            }
            private set
            {
                SetProperty(ref _centerPointYPixels, value);
            }
        }

        /// <summary>
        /// Gets the collection of polygon points.
        /// </summary>
        public PointCollection Points { get; private set; }

        /// <summary>
        /// Gets or sets the pocket angular position in pixels.
        /// </summary>
        public double AngularPositionDegrees { get; set; }
        public double ReplaceYPositionPixels
        {
            get
            {
                return _replaceyPositionPixels;
            }
            set
            {
                SetProperty(ref _replaceyPositionPixels, value);
            }
        }

        public string Visibility
        {
            get { return _Visibility; }
            set
            {
                SetProperty(ref _Visibility, value);
            }
        }

        public double LineX1Position
        {
            get { return _lineX1Position; }
            set { SetProperty(ref _lineX1Position, value); }
        }

        public double LineY1Position
        {
            get { return _lineY1Position; }
            set { SetProperty(ref _lineY1Position, value); }
        }

        public double LineX2Position
        {
            get { return _lineX2Position; }
            set { SetProperty(ref _lineX2Position, value); }
        }

        public double LineY2Position
        {
            get { return _lineY2Position; }
            set { SetProperty(ref _lineY2Position, value); }
        }

        #endregion

        #region Methods

        /// <summary>
        /// The UpdatePocketShape method is called to update the shape that represents the pocket.
        /// This is triggered by a window resize.
        /// </summary>
        /// <param name="widthPixels"></param>
        /// <param name="heightPixels"></param>
        /// <param name="xPositionPixels"></param>
        /// <param name="yPositionPixels"></param>
        /// <param name="wheelCenterPointXPixels"></param>
        /// <param name="wheelCenterPointYPixels"></param>
        public void UpdatePocketShape(double widthPixels, double heightPixels, double xPositionPixels, double yPositionPixels, double wheelCenterPointXPixels, double wheelCenterPointYPixels)
        {
            // Update polygon.
            Points = new PointCollection();
            Points.Add(new System.Windows.Point(xPositionPixels, yPositionPixels));
            Points.Add(new System.Windows.Point(xPositionPixels + widthPixels, yPositionPixels));
            Points.Add(new System.Windows.Point(xPositionPixels + (Constants.PocketWidth1Percentage * widthPixels), yPositionPixels + heightPixels));
            Points.Add(new System.Windows.Point(xPositionPixels + (Constants.PocketWidth2Percentage * widthPixels), yPositionPixels + heightPixels));
            RaisePropertyChanged("Points");

            // Update the x/y position and width of the pocket.
            XPositionPixels = xPositionPixels;
            YPositionPixels = yPositionPixels;
            WidthPixels = widthPixels;

            // Update wheel center point.
            CenterPointXPixels = wheelCenterPointXPixels;
            CenterPointYPixels = wheelCenterPointYPixels;

            InputYPositionPixels = yPositionPixels;  //initialize position
            ReplaceYPositionPixels = yPositionPixels;
        }

        public void UpdateLabelText(double xPositionPixels, double inputYPositionPixels)
        {
            xPositionPixels = XPositionPixels;
            InputYPositionPixels = YPositionPixels - 40;
        }

        public void UpdateReplaceText(double xPositionPixels, double replaceYPositionPixels)
        {
            xPositionPixels = XPositionPixels;
            ReplaceYPositionPixels = YPositionPixels - 20;
        }

        public void UpdateImage(double xPositionPixels, double imageYPositionPixels)
        {
            xPositionPixels = XPositionPixels;
            ImageYPositionPixels = YPositionPixels;
        }

        public void UpdateLine(double x1, double y1, double x2, double y2)
        {
            LineX1Position = x1;
            LineY1Position = y1;
            LineX2Position = x2;
            LineY2Position = y2;
        }

        #endregion
    }
}
