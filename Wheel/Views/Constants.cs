namespace Wheel.Views
{
    /// <summary>
    /// The Constants class contains any constants.
    /// </summary>
    public static class Constants
    {
        public const string WheelName = "Wheel";
        public const string WheelRotateTransformName = "rotateTransform";
        public const string BallName = "Ball";
        public const string BallRotateTransformName = "BallRotateTransform";
        public const string BallTranslateTransformName = "BallTranslateTransform";
        public const double MidPoint = 0.5;
        public const double StartAngle = 0;
        public const double StartPosition = 0;
        public const double WheelSpeedRatio = 2;
        public const double WheelDecelerationRatio = 0.50;
        public const int WheelSpinDurationSeconds = 0; //23
        public const int MinimumWheelSpinDistanceDegrees = 1080;
        public const int MaximumWheelSpinDistanceDegrees = 2161;
        public const double BallSpeedRatio = 4;
        public const double BallDecelerationRatio = 0.25;
        public const double BallFallPercent = 0.65;
        public const double StoppingDecelerationRatio = 1;
        public const int StoppingSpinDistanceDegrees = 1080;
        public const double FullCircleDegrees = 360;
        public const double OuterWheelDiameterPercentage = 0.95;
        public const double CenterWheelDiameterPercentage = 0.80;
        public const double InnerWheelDiameterPercentage = 0.76;
        public const double BallDiameterPercentage = 0.03;
        public const double BallYOffsetPercentage = 0.90;
        public const int MinimumWinningNumber = 0;
        public const int MaximumWinningNumber = 37;
        public const string BallAudioFile = @"\Sounds\ball_rolling.wav";
        public static readonly int[] WheelNumber = { 0, 32, 15, 19, 4, 21, 2, 25, 17, 34, 6, 27, 13, 36, 11, 30, 8, 23, 10, 5, 24, 16, 33, 1, 20, 14, 31, 9, 22, 18, 29, 7, 28, 12, 35, 3, 26 };
    }
}
