/* @flow */

import { setupSDK, insertMockSDKScript } from '@paypal/sdk-client/src';

import * as paypalCheckout from '../src/interface/button'; // eslint-disable-line import/no-namespace
import * as paypalWallet from '../src/interface/wallet'; // eslint-disable-line import/no-namespace
import * as paypalMarks from '../src/interface/marks'; // eslint-disable-line import/no-namespace

insertMockSDKScript();

window.mockDomain = 'mock://www.paypal.com';

setupSDK([
    {
        name:     'paypal-checkout',
        requirer: () => paypalCheckout
    },
    {
        name:     'paypal-wallet',
        requirer: () => paypalWallet
    },
    {
        name:     'paypal-marks',
        requirer: () => paypalMarks
    }
]);
