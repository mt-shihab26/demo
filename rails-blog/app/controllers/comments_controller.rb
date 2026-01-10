class CommentsController < ApplicationController
  before_action :set_post

  def create
    @post.comments.create! params.expect(comment: [ :content ])
    redirect_to @post
  end

  def destroy
    @comment = @post.comments.find(params[:id])
    @comment.destroy
    redirect_to @post, notice: "Comment was successfully deleted."
  end

  private
    def set_post
      @post = Post.find(params[:post_id])
    end
end
