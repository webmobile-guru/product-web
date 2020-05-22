/* @flow */
/** @jsx node */

import { node, Fragment } from 'jsx-pragmatic/src';
import { CARD, COUNTRY, COMPONENTS } from '@paypal/sdk-constants/src';
import { GlyphCard } from '@paypal/sdk-logos/src';

import { BUTTON_LAYOUT, BUTTON_COLOR, DEFAULT, CLASS } from '../../constants';
import { DEFAULT_FUNDING_CONFIG, type FundingSourceConfig, type CardConfig } from '../common';
import { Text, Space } from '../../ui/text';
import { isRTLLanguage } from '../../lib';

import { getVisaConfig } from './visa';
import { getMastercardConfig } from './mastercard';
import { getAmexConfig } from './amex';
import { getDiscoverConfig } from './discover';
import { getHiperConfig } from './hiper';
import { getEloConfig } from './elo';
import { getJCBConfig } from './jcb';

function getVendorConfig() : { [$Values<typeof CARD>] : ?CardConfig } {
    return {
        [ CARD.VISA ]:       (!__TREE_SHAKE__ || (__FUNDING_ELIGIBILITY__.card && __FUNDING_ELIGIBILITY__.card.vendors && __FUNDING_ELIGIBILITY__.card.vendors.visa && __FUNDING_ELIGIBILITY__.card.vendors.visa.eligible)) ? getVisaConfig() : null,
        [ CARD.AMEX ]:       (!__TREE_SHAKE__ || (__FUNDING_ELIGIBILITY__.card && __FUNDING_ELIGIBILITY__.card.vendors && __FUNDING_ELIGIBILITY__.card.vendors.amex && __FUNDING_ELIGIBILITY__.card.vendors.amex.eligible)) ? getAmexConfig() : null,
        [ CARD.MASTERCARD ]: (!__TREE_SHAKE__ || (__FUNDING_ELIGIBILITY__.card && __FUNDING_ELIGIBILITY__.card.vendors && __FUNDING_ELIGIBILITY__.card.vendors.mastercard && __FUNDING_ELIGIBILITY__.card.vendors.mastercard.eligible)) ? getMastercardConfig() : null,
        [ CARD.DISCOVER ]:   (!__TREE_SHAKE__ || (__FUNDING_ELIGIBILITY__.card && __FUNDING_ELIGIBILITY__.card.vendors && __FUNDING_ELIGIBILITY__.card.vendors.discover && __FUNDING_ELIGIBILITY__.card.vendors.discover.eligible)) ? getDiscoverConfig() : null,
        [ CARD.JCB ]:        (!__TREE_SHAKE__ || (__FUNDING_ELIGIBILITY__.card && __FUNDING_ELIGIBILITY__.card.vendors && __FUNDING_ELIGIBILITY__.card.vendors.jcb && __FUNDING_ELIGIBILITY__.card.vendors.jcb.eligible)) ? getJCBConfig() : null,
        [ CARD.ELO ]:        (!__TREE_SHAKE__ || (__FUNDING_ELIGIBILITY__.card && __FUNDING_ELIGIBILITY__.card.vendors && __FUNDING_ELIGIBILITY__.card.vendors.elo && __FUNDING_ELIGIBILITY__.card.vendors.elo.eligible)) ? getEloConfig() : null,
        [ CARD.HIPER ]:      (!__TREE_SHAKE__ || (__FUNDING_ELIGIBILITY__.card && __FUNDING_ELIGIBILITY__.card.vendors && __FUNDING_ELIGIBILITY__.card.vendors.hiper && __FUNDING_ELIGIBILITY__.card.vendors.hiper.eligible)) ? getHiperConfig() : null
    };
}

export function getCardConfig() : FundingSourceConfig {

    const vendors = getVendorConfig();

    const maxCardForCountry = {
        [ COUNTRY.BR ]: 5
    };

    return {
        ...DEFAULT_FUNDING_CONFIG,

        eligible: ({ components, fundingEligibility }) => {
            const hostedFieldsRequested = Boolean(components.indexOf(COMPONENTS.HOSTED_FIELDS) !== -1);
            const cardEligible = Boolean(fundingEligibility.card && fundingEligibility.card.eligible);
            const cardBranded = Boolean(fundingEligibility.card && fundingEligibility.card.branded);

            // If card is not eligible, never show card buttons
            if (!cardEligible) {
                return false;
            }

            // If card is branded, always show card buttons
            if (cardBranded) {
                return true;
            }
            
            // If hosted fields is requested, do not show card buttons
            if (hostedFieldsRequested) {
                return false;
            }
            
            // Otherwise default to show card buttons
            return true;
        },
        
        layouts: [
            BUTTON_LAYOUT.VERTICAL
        ],

        maxCards: maxCardForCountry,

        vendors,

        colors: [
            BUTTON_COLOR.BLACK,
            BUTTON_COLOR.WHITE
        ],

        secondaryColors: {
            ...DEFAULT_FUNDING_CONFIG.secondaryColors,
            [ DEFAULT ]: BUTTON_COLOR.BLACK
        },

        logoColors: {
            [ BUTTON_COLOR.WHITE  ]:  BUTTON_COLOR.BLACK,
            [ DEFAULT ]:              BUTTON_COLOR.WHITE
        },

        Logo: ({ logoColor }) => {
            return (
                <GlyphCard color={ logoColor } />
            );
        },

        Label: ({ logo, locale, content }) => {
            const { lang } = locale;
            const isRTL = isRTLLanguage(lang);
            return (
                <Fragment>
                    { isRTL ? (
                        <Fragment>
                            <Text optional>{ content.payWithDebitOrCreditCard }</Text>
                            <Space />
                        </Fragment>
                    ) : null }
                    { logo }
                    { !isRTL ? (
                        <Fragment>
                            <Space />
                            <Text optional>{ content.payWithDebitOrCreditCard }</Text>
                        </Fragment>
                    ) : null }
                </Fragment>
            );
        },

        VaultLabel: ({ vendor, label } : { vendor? : $Values<typeof CARD>, label : string }) => {
            if (!vendor) {
                throw new Error(`Vendor required for card vault label`);
            }

            const vendorConfig = vendors[vendor];

            if (!vendorConfig) {
                throw new Error(`Could not find vendor config for ${ vendor }`);
            }

            const { Label } = vendorConfig;

            return (
                <Fragment>
                    <Label optional /> <Text className={ CLASS.VAULT_LABEL }>{ label }</Text>
                </Fragment>
            );
        }
    };
}
