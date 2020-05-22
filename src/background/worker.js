var db = require('../db/database');
var Source = require('../domain/source');
var AliRequest = require('../domain/alirequest');
var AliQueue = require('../domain/aliqueue');
var callApifyMain = require('../services/main');
var moment = require('moment');
const uuidv1 = require('uuid/v1');

const aliExpressWorker = (product) => {
    db.query(Source.getSourceByFieldNameSQL('store_language'), [product.language], (err, data) => {
        if(!err) {
            if(data && data.length > 0) {
                let domain = data[0].store_url
                let params = {
                    uuid: uuidv1(),
                    num_products: 0,
                    created_at: moment(Date.now()).format("YYYY-MM-DD hh:mm:ss"),
                    updated_at: moment(Date.now()).format("YYYY-MM-DD hh:mm:ss")
                }
                let aliRequest = new AliRequest()
                db.query(aliRequest.getAddAliRequestSQL(), params, (err, data) => {
                    let params = {
                        uuid: uuidv1(),
                        product_code: product.code.toString(),
                        language: product.language,
                        product_info_payload: null,
                        status: "READY",
                        imported: 0,
                        created_at: moment(Date.now()).format("YYYY-MM-DD hh:mm:ss"),
                        updated_at: moment(Date.now()).format("YYYY-MM-DD hh:mm:ss")
                    }
                    let aliQueue = new AliQueue();
                    db.query(aliQueue.getAddAliQueueSQL(), params, (err, data) => {
                        let startUrl =  domain + 'item/' + product.code + '.html';
                        db.query(AliQueue.getAliQueueByFieldNameSQL('status'), ['READY'], (err, data)=>{
                            if(!err) {
                                if(data && data.length > 0) {
                                    data.map((d, key)=>{
                                        if (d.product_code === product.code.toString()){
                                            let params = [
                                                'RESERVED', 
                                                moment(Date.now()).format("YYYY-MM-DD hh:mm:ss"), 
                                                moment(Date.now()).format("YYYY-MM-DD hh:mm:ss"),
                                                product.code.toString()
                                            ];
                                            let fields = 'status = ?, reserved_at = ?, updated_at = ?';
                                            let condition = 'product_code = ?';
                                            db.query(AliQueue.updateAliQueueByFieldNameSQL(fields, condition), params, async (err, data) => {
                                                await callApifyMain(startUrl);
                                            });
                                        }
                                    });
                                }
                            }
                        });
                    });
                });
            }
        }
    })
}

module.exports = {
    aliExpressWorker
}