<?php

// Instagram Widget

echo '<li class="' . esc_attr( $liclass ) . '">';
echo '<a href="' . esc_url( $item['link'] ) . '" target="' . esc_attr( $target ) . '"  class="' . esc_attr( $aclass ) . '">';
echo '<img src="' . esc_url( $item[ $size ] ) . '"  alt="' . esc_attr( $item['description'] ) . '" title="' . esc_attr( $item['description'] ) . '"  class="' . esc_attr( $imgclass ) . '"/>';
echo '<span class="insta-meta">';
echo '<span class="insta-likes"><i class="fa fa-heart-o fa-fw"></i>' . esc_html( $item['likes'] ) . '</span>';
echo '<span class="insta-comments"><i class="fa fa-comment-o fa-fw"></i>' . esc_html( $item['comments'] ) . '</span>';
echo '</span>';
echo '</a>';
echo '</li>';
