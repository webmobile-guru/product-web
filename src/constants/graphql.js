import gql from 'graphql-tag'

export const WOA_QUERY = gql`
  query woaQuery($item_id: String!, $lang: String!) {
      woa(item_id: $item_id, lang: $lang) {
          id
          item_id
          name
          media_audio_mp3
          media_image_file
          type
          date_of_collecting
          location_txt_locality
          location_txt_archaic
          location_txt_county
          nationality
          origin_txt
          lyrics
          collector_comment
          media_video_youtube_code
          media_files
          audio_tracks
          taxonomies {
            id
            name
            parents {
              id
              name
            }
          }
          collectors {
            id
            name
          }
          sources {
            id
            name
          }
          descriptors {
            id
            name
          }
          woas {
            id
            name
            item_id
            type
          }
      }
  }
`

export const MAP_QUERY = gql`
  query mapQuery($lang: String!, $order: String) {
    woas (lang: $lang, order: $order) {
      id
      date_of_collecting
      location_address
      location_txt_locality
      nationality
      type
    }
  }
`
