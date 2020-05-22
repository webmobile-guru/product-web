const { WebClient } = require("@slack/client");
// set your token to the bot token provided by slack
const token = CONFIG.xoxb;
if (!token) {
  console.log("You must specify a token to use this example");
  return;
}
const web = new WebClient(token);
const getChannels = async () => {
  const res = await web.channels.list();
  return res.channels.map(channel => ({ id: channel.id, name: channel.name }));
};
/**
 * Post message
 * {
 * 		"channelName": "random",
 *      "blocks": [{"type": "section", "text": {"type": "plain_text", "text": "Hello world"}}]
 * }
 */
exports.postMessage = SlackJson => {
  const { blocks, channelName } = SlackJson;
  return new Promise(async (resolve, reject) => {
    const channels = await getChannels();
    const randomChannel = channels.find(channel => channel.name === channelName);
    web.chat
      .postMessage({
        channel: randomChannel.id,
        blocks
      })
      .then(res => {
        // `res` contains information about the posted message
        resolve(res.ts);
      })
      .catch(err => reject(err));
  });
};
