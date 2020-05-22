// routes.js
const Apify = require('apify');
const extractors = require('./extractors');
var moment = require('moment');

var db = require('../db/database');
var AliQueue = require('../domain/aliqueue');
var Store = require('../domain/store');

const {
    utils: { log },
} = Apify;

// Product page crawler
// Fetches product detail from detail page
exports.PRODUCT = async ({ $, userInput, request }, { requestQueue }) => {
    const { productId } = request.userData;
    const { includeDescription } = userInput;
    let product = ''
    log.info(`CRAWLER -- Fetching product: ${productId}`);

    // Fetch product details
    try {
        product = await extractors.getProductDetail($, request.url);
    } catch (error) {
        await new Promise((resolve, reject) => {
            let params = [
                'FAILED', 
                moment(Date.now()).format("YYYY-MM-DD hh:mm:ss"), 
                moment(Date.now()).format("YYYY-MM-DD hh:mm:ss"),
                productId.toString()
            ];
            let fields = 'status = ?, failed_at = ?, updated_at = ?';
            let condition = 'product_code = ?';
            db.query(AliQueue.updateAliQueueByFieldNameSQL(fields, condition), params, (err, data)=>{
                resolve();
            });
        });
    } finally {
        // Check description option
        if (includeDescription) {
            // Fetch description
            await requestQueue.addRequest({
                url: product.descriptionURL,
                userData: {
                    label: 'DESCRIPTION',
                    product,
                },
            }, { forefront: true });
        } else {
            await new Promise((resolve, reject) => {
                let params = {
                    store_id: product['store']['id'],
                    store_name: product['store']['name'],
                    store_url: product['store']['url'],
                    store_feedbacks: parseFloat(product['store']['positiveRate']),
                    seller_since: moment(product['store']['establishedAt'], 'MMM D, YYYY').format('YYYY-MM-DD'),
                    created_at: moment(Date.now()).format("YYYY-MM-DD hh:mm:ss"),
                    modified_at: moment(Date.now()).format("YYYY-MM-DD hh:mm:ss")
                };
                let store = new Store();
                db.query(store.getAddStoreSQL(), params, (err, data) => {
                    let params = [
                        'FINISHED', 
                        moment(Date.now()).format("YYYY-MM-DD hh:mm:ss"),
                        JSON.stringify(product),
                        moment(Date.now()).format("YYYY-MM-DD hh:mm:ss"),
                        productId.toString()
                    ];
                    let fields = 'status = ?, finished_at = ?, product_info_payload = ?, updated_at = ?';
                    let condition = 'product_code = ?';
                    db.query(AliQueue.updateAliQueueByFieldNameSQL(fields, condition), params, (err, data)=>{
                        resolve();
                    });
                });
            });
            await Apify.pushData({ ...product });
            console.log(`CRAWLER -- Fetching product: ${productId} completed and successfully pushed to dataset`);
        }
    }
};

// Description page crawler
// Fetches description detail and push data
exports.DESCRIPTION = async ({ $, request }) => {
    const { product } = request.userData;

    log.info(`CRAWLER -- Fetching product description: ${product.id}`);

    // Fetch product details
    const description = await extractors.getProductDescription($);
    product.description = description;
    delete product.descriptionURL;

    // Push data
    await Apify.pushData({ ...product });

    log.debug(`CRAWLER -- Fetching product description: ${product.id} completed and successfully pushed to dataset`);
};
