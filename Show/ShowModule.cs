using Show.Views;
using Prism.Ioc;
using Prism.Modularity;
using Prism.Regions;
using RouletteSimulator.Core;

namespace Show
{
    public class ShowModule : IModule
    {
        #region Fields

        private readonly IRegionManager _regionManager;

        #endregion

        #region Constructors

        /// <summary>
        /// Constructor.
        /// </summary>
        /// <param name="regionManager"></param>
        public ShowModule(IRegionManager regionManager)
        {
            _regionManager = regionManager;
        }

        /// <summary>
        /// The OnInitialized method is called when the module is initialized.
        /// </summary>
        /// <param name="containerProvider"></param>
        public void OnInitialized(IContainerProvider containerProvider)
        {
            _regionManager.RegisterViewWithRegion(RegionNames.ShowRegion, typeof(ShowView));
        }

        /// <summary>
        /// The RegisterTypes method is called to register pages for navigation.
        /// </summary>
        /// <param name="containerRegistry"></param>
        public void RegisterTypes(IContainerRegistry containerRegistry)
        {
        }

        #endregion

        #region Events
        #endregion

        #region Properties
        #endregion

        #region Methods
        #endregion
    }
}