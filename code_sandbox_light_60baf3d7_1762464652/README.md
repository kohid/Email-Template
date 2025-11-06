# TDT Email Template Builder

A powerful WordPress plugin that provides a drag-and-drop email template builder with customizable widgets and responsive design capabilities.

## Features

### Core Functionality

- **Drag & Drop Interface**: Intuitive visual builder for creating email templates
- **15+ Widget Types**: Container, Heading, Text, Image Box, Button, Video, Social, and more
- **Responsive Design**: Switch between desktop and mobile views
- **Real-time Preview**: See your template as you build it
- **Template Library**: Save and reuse your favorite templates

### Widget Types

1. **Container** - Flexible container for organizing content
2. **Heading** - H1-H6 headings with customizable styling
3. **Text** - Paragraph text with rich formatting options
4. **Image Box** - Image with caption and link support
5. **List Icon Text** - List items with icons
6. **Call to Action** - Promotional sections
7. **Navigation** - Navigation menus
8. **Button** - Customizable buttons with hover effects
9. **Image** - Single images with alt text and links
10. **Video** - Video embeds with start/end times
11. **Social** - Social media links and icons
12. **HTML** - Custom HTML code
13. **Spacer** - Adjustable spacing elements
14. **Divider** - Horizontal divider lines
15. **Product** - Product showcase widgets
16. **Payment Link** - Payment buttons and links

### Advanced Features

- **Settings Modal** with three tabs:
  - **Template**: Body width, background color, text direction
  - **Canvas**: Width, background, padding, margin, border radius, box shadow
  - **Typography**: Global settings for headings, paragraphs, links, and buttons

### Property Panels

Each widget has comprehensive property panels:

- **Content Tab**: Text, images, links, and widget-specific content
- **Style Tab**: Alignment, colors, typography, spacing
- **Advanced Tab**: CSS classes, IDs, margins, padding, visibility settings

### Additional Features

- **Export HTML**: Export templates as HTML files
- **Duplicate Templates**: Quickly copy existing templates
- **Template History**: Track changes (coming soon)
- **Media Library Integration**: Access WordPress media library for images
- **Responsive Controls**: Device-specific visibility settings

## Installation

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to **Email Templates** → **Add New Template** to start building

## Usage

### Creating a Template

1. Go to **Email Templates** → **Add New Template**
2. Enter a template name
3. Drag widgets from the left panel to the canvas
4. Click on widgets to select them and edit properties
5. Use the settings modal (gear icon) to configure global settings
6. Click **Save** to save your template
7. Click **Preview** to see how it looks

### Widget Properties

- **Content**: Edit text, images, links, and other content
- **Style**: Customize colors, fonts, alignment, and spacing
- **Advanced**: Add CSS classes, set margins/padding, configure visibility

### Settings Modal

Access the settings modal by clicking the gear icon in the header:

#### Template Tab

- Body width and background color
- Text direction (LTR/RTL)

#### Canvas Tab

- Canvas width and background color
- Padding and margin settings
- Border radius and box shadow

#### Typography Tab

- **Headings**: Font family, size, weight, color
- **Paragraphs**: Font family, size, line height, color
- **Links**: Color, hover color, text decoration
- **Buttons**: Background color, text color, hover background, border radius

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- Modern web browser with JavaScript enabled

## File Structure

```
tdt-email-template/
├── assets/
│   ├── css/
│   │   └── admin.css
│   ├── js/
│   │   └── admin.js
│   └── images/
│       └── placeholder.png
├── includes/
│   ├── admin/
│   │   ├── class-admin.php
│   │   ├── class-templates.php
│   │   └── views/
│   │       ├── email-builder.php
│   │       ├── templates-list.php
│   │       └── settings.php
│   ├── class-ajax-handler.php
│   ├── class-frontend.php
│   └── class-template-renderer.php
├── languages/
└── tdt-email-template.php
```

## Hooks and Filters

### Actions

- `tdt_email_template_before_widget` - Before widget output
- `tdt_email_template_after_widget` - After widget output
- `tdt_email_template_before_save` - Before template save
- `tdt_email_template_after_save` - After template save

### Filters

- `tdt_email_template_widget_types` - Modify available widget types
- `tdt_email_template_default_settings` - Modify default settings
- `tdt_email_template_preview_html` - Modify preview HTML
- `tdt_email_template_export_html` - Modify export HTML

## AJAX Endpoints

- `tdt_get_template_settings` - Get template settings
- `tdt_save_template_settings` - Save template settings
- `tdt_get_widgets` - Get available widgets
- `tdt_get_widget_html` - Get widget HTML
- `tdt_get_widget_properties` - Get widget properties
- `tdt_save_template` - Save template
- `tdt_preview_template` - Preview template
- `tdt_export_template` - Export template as HTML

## JavaScript API

The plugin exposes a global JavaScript object `tdtEmailBuilder` with methods for:

- Widget management
- Template settings
- Canvas manipulation
- Event handling

## Security

- All AJAX requests are protected with WordPress nonces
- User capability checks on all admin functions
- Input sanitization and output escaping
- Prepared statements for database queries

## Performance

- Optimized CSS and JavaScript loading
- AJAX-based operations for better user experience
- Efficient database queries
- Caching support for template output

## Browser Compatibility

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Future Enhancements

- [ ] Template categories and tags
- [ ] Advanced animation effects
- [ ] A/B testing functionality
- [ ] Email service provider integrations
- [ ] Import/export templates between sites
- [ ] Advanced responsive controls
- [ ] Custom CSS editor
- [ ] Widget marketplace

## Support

For support and feature requests, please create an issue in the plugin repository.

## License

This plugin is licensed under the GPL v2 or later.

## Credits

- Built with WordPress best practices
- Uses Font Awesome for icons
- jQuery UI for drag-and-drop functionality
- Modern CSS3 and vanilla JavaScript
