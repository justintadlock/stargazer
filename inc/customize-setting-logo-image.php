<?php



class Stargazer_Customize_Setting_Logo_Image extends WP_Customize_Setting {

	public $logo_width;
	public $logo_height;
	public $logo_id;
	public $logo_url;

	protected function update( $value ) {

		if ( !empty( $value ) ) {

			update_post_meta( $this->logo_id, '_wp_attachment_is_custom_logo', get_stylesheet() );

			set_theme_mod( 'logo_image', $value );

			set_theme_mod(
				'logo_image_data',
				array(
					'attachment_id' => $this->logo_id,
					'url'           => $value,
					'width'         => $this->logo_width,
					'height'        => $this->logo_height
				)
			);
		} else {

			remove_theme_mod( 'logo_image' );
			remove_theme_mod( 'logo_image_data' );
		}

		return $value;
	}

	public function sanitize( $url ) {
			global $wpdb;

			$this->logo_url = $url;

			if ( empty( $url ) ) {
				add_filter( 'theme_mod_logo_image_data', array( $this, 'logo_image_data' ) );

				return $url;
			}

			$upload_dir = wp_upload_dir();

			$file = str_replace( trailingslashit( strtolower( $upload_dir['baseurl'] ) ), '', $url );

			$post_id = $wpdb->get_var( 
				$wpdb->prepare( 
					"SELECT post_id FROM $wpdb->postmeta WHERE 
						(meta_key = '_wp_attachment_metadata' AND meta_value LIKE %s) OR 
						(meta_key = '_wp_attachment_backup_sizes' AND meta_value LIKE %s) 
						LIMIT 1;", 
					'%"' . like_escape( $file ) . '"%', 
					'%"' . like_escape( basename( $file ) ) . '"%' 
				) 
			);

			if ( !empty( $post_id ) ) {

				add_filter( 'theme_mod_logo_image_data', array( $this, 'logo_image_data' ) );

				$this->logo_id     = $post_id;
				$this->logo_width  = $width  = 100;
				$this->logo_height = $height = 65;

				$file = get_attached_file( $post_id );
				$meta = wp_get_attachment_metadata( $post_id );

				if ( isset( $meta['sizes']['custom_logo'] ) ) {

					$this_size = $meta['sizes']['custom_logo'];

					if ( $width == $this_size['width'] || $height == $this_size['height'] ) {
						$image_src = wp_get_attachment_image_src( $post_id, 'custom_logo' );

						$this->logo_width  = $image_src[1];
						$this->logo_height = $image_src[2];
						$this->logo_url    = $image_src[0];

						return $this->logo_url;
					}
				}

				foreach( $meta['sizes'] as $key => $size ) {

					if ( $size['width'] == $width && $size['height'] == $height ) {

						$image_src = wp_get_attachment_image_src( $post_id, $key );

						$this->logo_width  = $image_src[1];
						$this->logo_height = $image_src[2];
						$this->logo_url    = $image_src[0];

						return $this->logo_url;
					}
				}

				$resized = image_make_intermediate_size( $file, $width, $height, false );

				if ( false !== $resized ) {

					$image = str_replace(
						array( $upload_dir['basedir'], basename( $file ) ),
						array( $upload_dir['baseurl'], $resized['file'] ),
						$file
					);

					$this->logo_width  = $resized['width'];
					$this->logo_height = $resized['height'];

					$meta['sizes']['custom_logo'] = $resized;

					wp_update_attachment_metadata( $post_id, $meta );

					$backup_sizes = get_post_meta( $post_id, '_wp_attachment_backup_sizes', true );

					if ( !is_array( $backup_sizes ) )
						$backup_sizes = array();

					$backup_sizes['custom_logo'] = $resized;

					update_post_meta( $post_id, '_wp_attachment_backup_sizes', $backup_sizes );

					$this->logo_url = $image;

					return $this->logo_url;
				}
			}

			return $url;
	}

	public function logo_image_data( $data ) {

		if ( empty( $this->logo_url ) )
			return array();

		$data['url']           = $this->logo_url;
		$data['width']         = $this->logo_width;
		$data['height']        = $this->logo_height;
		$data['attachment_id'] = $this->logo_id;

		return $data;
	}
}



?>