var mongoose = require('mongoose');
const autopopulate = require('mongoose-autopopulate');

/**
 * Currently using UploadCare; pulls these traits from the upload obj
 */
const CompanySchema = mongoose.Schema({

    companyName: {
        type: String,
        required: true,
    },
    emailDomain: {
        type: String,
        required: true
    },

}, {
    timestamps: true
});

CompanySchema.plugin(autopopulate);

const Company = mongoose.model('Company', CompanySchema);

module.exports = Company;