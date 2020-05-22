/* @flow */
/* eslint max-lines: 0 */

import { wrapPromise } from 'belter/src';

import { createTestContainer, destroyTestContainer, generateOrderID } from '../common';

for (const flow of [ 'popup', 'iframe' ]) {

    describe(`paypal button component happy path on ${ flow }`, () => {

        beforeEach(() => {
            createTestContainer();
        });

        afterEach(() => {
            destroyTestContainer();
        });

        it('should render a button with popup bridge', () => {
            return wrapPromise(({ expect, avoid }) => {
                const orderID = generateOrderID();
                const payerID = 'YYYYYYYYYY';

                window.popupBridge = {
                    open: expect('open', () => {
                        window.popupBridge.onComplete(null, {
                            queryItems: {
                                token:   orderID,
                                payerId: payerID
                            }
                        });
                    }),
                    getReturnUrlPrefix: expect('getReturnUrlPrefix', () => {
                        return 'native://foobar';
                    })
                };

                return window.paypal.Buttons({

                    test: { flow, action: 'checkout' },

                    createOrder: expect('createOrder', () => orderID),

                    onApprove: expect('onApprove', (data) => {
                        if (data.orderID !== orderID) {
                            throw new Error(`Expected orderID to be ${ orderID }, got ${ data.orderID }`);
                        }

                        if (data.payerID !== payerID) {
                            throw new Error(`Expected payerID to be ${ payerID }, got ${ data.payerID }`);
                        }
                    }),
                    onCancel:  avoid('onCancel')

                }).render('#testContainer');
            });
        });

        it('should render a button with popup bridge and throw an error', () => {
            return wrapPromise(({ expect, avoid }) => {
                const orderID = generateOrderID();

                window.popupBridge = {
                    open: expect('open', () => {
                        window.popupBridge.onComplete(new Error('something went wrong'));
                    }),
                    getReturnUrlPrefix: expect('getReturnUrlPrefix', () => {
                        return 'native://foobar';
                    })
                };

                return window.paypal.Buttons({
                    test: { flow, action: 'checkout' },

                    createOrder: expect('createOrder', () => orderID),

                    onError:  expect('onError'),
                    onCancel: avoid('onCancel')

                }).render('#testContainer');
            });
        });
    });
}
