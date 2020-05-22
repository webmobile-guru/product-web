const Tag = require('../models').Tag;
const Company = require('../models').Company;

exports.create = async function (tagJson) {
    let err, newTag;

    // see if exists already
    [err, oldTag] = await to(Tag.findOne({company: tagJson.company, name: tagJson.name}));
    if(oldTag) TE('Tag already exists.');

    [err, newTag] = await to(Tag.create(tagJson));
    if (err) TE("Unable to create tag: " + err.message);

    return newTag;
}

exports.deleteTag = async function(tagId) {
    let err, _;
    
    [err, _] = await to(Tag.findByIdAndDelete(tagId));
    if (err) TE("Unable to delete tag: " + err.message);
}