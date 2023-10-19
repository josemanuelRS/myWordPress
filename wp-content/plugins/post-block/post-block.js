const { registerBlockType, createBlock } = wp.blocks;
const { TextControl, SelectControl } = wp.components;
const { withSelect } = wp.data;

registerBlockType('webthinker/my-post-block', {
  title: 'My Post Block',
  icon: 'smiley',
  category: 'design',
  attributes: {
    title: {
      type: 'string',
      default: '',
    },
    text: {
      type: 'string',
      default: '',
    },
    postId: {
      type: 'string',
      default: '0',
    }
  },

  edit: withSelect((select) => {
    const { getEntityRecords } = select('core');

    // Get Posts
    const posts = getEntityRecords('postType', 'post', { per_page: -1 });

    return {
      posts: posts || [],
    };
  })(({ attributes, setAttributes, posts }) => {
    const handleSliderChange = (newValue) => {
      setAttributes({ postId: newValue });
    };

    const handleAddPostClick = () => {
      
      const selectedPostId = attributes.postId;

      if (selectedPostId !== '0') {
        // Get the selected Post
        const selectedPost = posts.find((post) => post.id.toString() === selectedPostId);

        if (selectedPost) {

          // Create a paragraph block with title and content
          const paragraphBlock = createBlock('core/paragraph', {
            content: `
            <h4>${attributes.title}</h4><br>${attributes.text}<br><br>
            <h2>${selectedPost.title.rendered}</h2>
            <br>${selectedPost.content.rendered}<br><hr />`,
          });

          // Insert the block in the editor
          wp.data.dispatch('core/editor').insertBlocks(paragraphBlock);
        }
      }
    };

    return React.createElement('div', null,
      React.createElement("label", null, "Title"),
      React.createElement(TextControl, {
        value: attributes.title,
        onChange: function(newValue) {
          return setAttributes({ title: newValue });
        }
      }),
      React.createElement("label", null, "Text"),
      React.createElement(TextControl, {
        value: attributes.text,
        onChange: function(newValue) {
          return setAttributes({ text: newValue });
        }
      }),
      React.createElement('label', null, 'Select Post'),
      React.createElement(SelectControl, {
        options: [
          { value: '0', label: 'Select a Post' },
          ...(posts || []).map((post) => ({
            value: post.id.toString(),
            label: post.title.rendered
          }))
        ],
        value: attributes.postId.toString(),
        onChange: handleSliderChange
      }),
      React.createElement('button', {
        className: 'wp-block-button',
        onClick: handleAddPostClick
      }, 'Add Post')
    );
  }),

  save: ({ attributes }) => {
    return null; //
  }

});